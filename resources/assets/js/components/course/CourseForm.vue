<template>
    <el-row type="flex">
        <el-col :span="20">
            <el-dialog
                    title="挂载资源"
                    :visible.sync="resourceVisible"
                    width="60%"
                    center
            >

                <el-tabs v-model="attachResourceActiveName">
                    <el-tab-pane label="上传资源" name="uploader">
                        <el-row type="flex" justify="center">
                            <el-col>
                                <el-upload
                                        class="upload-demo justify-content-center"
                                        :on-preview="onUploadPreview"
                                        :on-exceed="onExceed"
                                        :before-upload="onBeforeUpload"
                                        :http-request="uploadHttpRequest"
                                        type="flex"
                                        justify="center"
                                        drag
                                        multiple
                                >
                                    <i class="el-icon-upload"></i>
                                    <div class="el-upload__text">将文件拖到此处，或<em>点击上传</em></div>
                                    <div class="el-upload__tip" slot="tip">只能上传jpg/png文件，且不超过500kb</div>
                                </el-upload>
                            </el-col>
                        </el-row>
                    </el-tab-pane>

                    <el-tab-pane label="选择资源" name="choice">
                        <el-table :data="resources" border >
                            <el-table-column prop="id" label="id" width="80"></el-table-column>
                            <el-table-column prop="title" label="标题"></el-table-column>
                            <el-table-column title="选择">
                                <template scope="scope">
                                    <el-checkbox v-model="scope.row.choose" label="选择"></el-checkbox>
                                </template>
                            </el-table-column>
                        </el-table>
                    </el-tab-pane>
                </el-tabs>

                <span slot="footer" class="dialog-footer">
                    <el-button @click="dialogVisible = false">取 消</el-button>
                    <el-button type="primary" @click="onClickAttachResourceConfirm">确 定</el-button>
                </span>

            </el-dialog>

            <el-tabs v-model="activeName" @tab-click="handleClick" v-loading="loading" v-if="!resourceVisible">
                <el-tab-pane label="课程信息" name="basic">
                    <el-form ref="form" :model="form" label-width="80px">
                        <el-form-item label="课程名称">
                            <el-input v-model="form.title" placeholder="请输入课程名称"></el-input>
                        </el-form-item>
                        <el-form-item label="课程介绍">
                            <el-input
                                    type="textarea"
                                    :autosize="{ minRows: 4, maxRows: 4}"
                                    placeholder="请输入内容"
                                    v-model="form.description">
                            </el-input>
                        </el-form-item>
                        <el-form-item label="课程封面">
                            <el-upload
                                    class="avatar-uploader"
                                    action="https://jsonplaceholder.typicode.com/posts/"
                                    :show-file-list="false"
                                    :on-success="handleAvatarSuccess"
                                    :before-upload="beforeAvatarUpload">
                                <img v-if="form.imageUrl" :src="form.imageUrl" class="avatar">
                                <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                            </el-upload>
                        </el-form-item>
                        <el-form-item>
                            <el-button type="primary" @click="onSubmit">立即创建</el-button>
                            <el-button>取消</el-button>
                        </el-form-item>
                    </el-form>
                </el-tab-pane>
                <el-tab-pane label="大纲" name="tableOfContents">
                    <el-row type="flex" justify="end">
                        <el-col :span="5">
                            <el-button class="button-add-root-node" justify="end" type="primary" size="small" @click="onClickAddRootNode">添加根节点</el-button>
                        </el-col>
                    </el-row>
                    <el-table :data="form.tableOfContents" border>
                        <el-table-column
                                prop="title"
                                label="标题">

                            <template scope="scope">
                                <div :style="{marginLeft: (scope.row.depth * 10 ) + 'px'}">
                                    <el-input v-if="scope.row.editing" v-model="scope.row.typingTitle" :focus="scope.row.inputFocus" @keyup.enter.native="onClickRowCompleteEdit(scope.row)" placeholder="请输入标题"></el-input>
                                    <span v-if="!scope.row.editing">{{scope.row.title}}</span>
                                </div>
                            </template>

                        </el-table-column>

                        <el-table-column prop="action" label="操作">
                            <template scope="scope" style="width: 100px">
                                <el-button v-if="!scope.row.editing" @click="onClickRowEdit(scope.row)" size="small">编辑</el-button>
                                <el-button v-if="scope.row.editing" @click="onClickRowCompleteEdit(scope.row)" size="small" type="primary" :ref="'confirm_' + scope.row.viewId" :loading="scope.row.loading">确认</el-button>
                                <el-button v-if="scope.row.editing" @click="onClickRowCancelEdit(scope.$index, scope.row)" size="small">取消</el-button>
                                <el-button v-if="!scope.row.isResource" @click="onClickAddChild(scope.$index, scope.row)" size="small">添加子节点</el-button>
                                <el-button v-if="!scope.row.isResource" @click="onClickAttachResource(scope.$index, scope.row)" size="small">挂载资源</el-button>
                            </template>
                        </el-table-column>

                    </el-table>
                </el-tab-pane>
            </el-tabs>
        </el-col>
    </el-row>

</template>
<style>
    .avatar-uploader .el-upload {
        border: 1px dashed #d9d9d9;
        border-radius: 6px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }
    .avatar-uploader .el-upload:hover {
        border-color: #409EFF;
    }
    .avatar-uploader-icon {
        font-size: 28px;
        color: #8c939d;
        width: 178px;
        height: 178px;
        line-height: 178px;
        text-align: center;
    }
    .avatar {
        width: 178px;
        height: 178px;
        display: block;
    }

    .button-add-root-node {
        margin: 10px 0px;
        width: 100%;
    }
</style>
<script>
    import TocTransfer from '../../TocTransfer'
    import ResourceChoiceComponent from './ResourceChoiceComponent'

    import TableOfContentViewModel from "./view/model/TableOfContentViewModel";
    import TableOfContentDTOAssembler from "./remote/TableOfContentDTOAssembler";

    export default {
        components: {
            'resource-choice': ResourceChoiceComponent
        },

        props: {
            id: {
                type: String
            },
            tableOfContentEditing: {
                type: Function
            },
            form: {
                type: Object,
                default() {
                    return {
                        title: '',
                        description: '',
                        tableOfCotnents: []
                    }
                }
            }
        },

        data() {
            return {
                resourceVisible: false,
                attachResourceActiveName: 'uploader',
                chooseAttachTOC: null,
                chooseAttachTOCIndex: -1,
                resources: [
                    {
                        id: 1,
                        title: '学习视频 1',
                        type: 'video',
                        choose: "选择"
                    },
                    {
                        id: 2,
                        title: '学习视频 2',
                        type: 'video',
                        choose: "选择"
                    }
                ],
                uploadURL: '',
                accessKey: '',
                signature: '',
                policy: '',
                uploadingResource: null,
                activeName: "tableOfContents",
                loading: false

            }
        },

        created() {
            if (!this.onTableOfContentEditing) {
                this.onTableOfContentEditing = (_) => {

                }
            }
        },

        mounted() {
        },


        methods: {
            handleClick() {

            },



            onClickAttachResourceConfirm() {

                this.addChild(this.chooseAttachTOCIndex, this.chooseAttachTOC, {
                    title: "123123",
                    editing: false,
                    inputFocus: false,
                    isResource: true,
                    resource_id: 40
                })

                this.resourceVisible = false
            },

            onUploadPreview(file) {
                console.debug(file)
            },

            onExceed(file, fileList) {
                console.debug(file)
                console.debug(fileList)
            },

            async onBeforeUpload(file) {

                const response = await this.$http.post(
                    '/api/resource/uploader',
                    {
                        raw_name: file.name,
                        size: file.size,
                        mime_type: file.type
                    }
                )
                
                this.uploadURL = response.data.upload_url
                this.signature = response.data.signature
                this.accessKey = response.data.access_key
                this.policy = response.data.policy
                this.object_path = response.data.object_path
                this.uploadingResource = response.data.resource
            },

            async uploadHttpRequest(request) {
                const formData = new FormData()

                formData.append('key', this.object_path)
                formData.append('file', request.file)
                formData.append('OSSAccessKeyId', this.accessKey)
                formData.append('policy', this.policy)
                formData.append('signature', this.signature)
                
                await this.$http.post(this.uploadURL, formData)
                await this.$http.put(
                    `/api/resource/${this.uploadingResource.id}/status`,
                    {
                        'status': 'available'
                    }
                )
            },

            onClickAttachResource(index, row) {
                this.chooseAttachTOC = row
                this.chooseAttachTOCIndex = index
                this.resourceVisible = true
            },

            async onClickRowCompleteEdit(row) {
                row.inputFocus = false
                row.title = row.typingTitle
                row.loading = true
                this.$refs['confirm_' + row.viewId].loading = true

                if (this.tableOfContentEditing)
                    await this.tableOfContentEditing(row)

                this.$refs['confirm_' + row.viewId].loading = false
                row.loading = false
                row.editing = false
            },

            onClickRowCancelEdit(index, row) {
                row.editing = false
                row.inputFocus = false

                if (!row.id && row.title == '')
                    this.form.tableOfContents.splice(index, 1)
            },

            onClickRowEdit(row) {
                row.editing = true
                row.inputFocus = true
            },


            addChild(index, parent, tableOfContent) {
                const findPosition = function(index, parent, tableOfContents) {
                    var foundIndex = -1

                    for (var i = index + 1, size = tableOfContents.length; i < size; i++) {
                        const found = tableOfContents[i]

                        if (parent.depth === found.depth) {
                            foundIndex = i
                            break
                        }

                        if (parent.depth > found.depth) {
                            foundIndex = i
                            break
                        }
                    }

                    if (-1 === foundIndex) {
                        foundIndex = tableOfContents.length
                    }

                    return foundIndex
                }

                this.form.tableOfContents.splice(
                    findPosition(index, parent, this.form.tableOfContents),
                    0,
                    tableOfContent
                )
            },

            onClickAddRootNode() {
                console.debug('on click add root node')
                this.form.tableOfContents.splice(
                    this.form.tableOfContents.length,
                    0,
                    new TableOfContentViewModel(
                        null,
                        "",
                        0,
                        true,
                        null
                    )
                )
            },

            onClickAddChild(index, parent) {
                this.addChild(
                    index,
                    parent,
                    new TableOfContentViewModel(
                        null,
                        "",
                        parent.depth + 1,
                        true,
                        null
                    )
                )
            },

            async onSubmit() {

                const course = {
                    title: this.form.title,
                    description: this.form.description
                }

                this.loading = true
                try {
                    await this.$http.put(`/api/course/${this.$route.params.id}`, course)
                } catch (e) {
                    console.error(e.message)
                    this.$message.error('编辑课程失败')
                }
                this.loading = false
                console.debug(response)
            },

            handleAvatarSuccess(res, file) {
                this.imageUrl = URL.createObjectURL(file.raw);
            },

            beforeAvatarUpload(file) {
                // const isJPG = file.type === 'image/jpeg';
                const isJPG = true
                const isLt2M = file.size / 1024 / 1024 < 2;

                // if (!isJPG) {
                //     this.$message.error('上传头像图片只能是 JPG 格式!');
                // }
                if (!isLt2M) {
                    this.$message.error('上传头像图片大小不能超过 2MB!');
                }
                return isJPG && isLt2M;
            }
        }
    }
</script>