<template>
    <el-row type="flex">
        <el-col :span="24">
            <el-dialog
                    title="挂载资源"
                    :visible.sync="resourceVisible"
                    width="60%"
                    center
                    v-loading="attachResourceDialogLoading"
            >

                <el-tabs v-model="attachResourceActiveName" @tab-click="onClickTabResourceList">
                    <el-tab-pane label="上传资源" name="uploader">
                        <el-row type="flex" justify="center">
                            <el-col>
                                <el-upload
                                        class="upload-demo justify-content-center"
                                        :on-preview="onUploadPreview"
                                        :on-exceed="onExceed"
                                        :before-upload="beforeUpload"
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
                        <el-table :data="resources" border v-loading="resourceLoading">
                            <el-table-column prop="id" label="id" width="80"></el-table-column>
                            <el-table-column prop="title" label="标题"></el-table-column>
                            <el-table-column title="选择" width="100">
                                <template scope="scope">
                                    <el-checkbox v-model="scope.row.chosen" label="选择" @change="onResourceSelectChanged"></el-checkbox>
                                </template>
                            </el-table-column>
                        </el-table>

                        <el-row class="block">
                            <el-col>
                                <el-pagination
                                    layout="prev, pager, next"
                                    :total="pageTotal"
                                    :page-size="pageSize"
                                    @current-change="pageChange">
                                </el-pagination>
                            </el-col>
                        </el-row>
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
                                    <el-input v-if="scope.row.editing" v-model="scope.row.typingTitle" :focus="scope.row.inputFocus" @keyup.enter.native="onClickRowCompleteEdit(scope.row)" placeholder="请输入标题" minlength="3" autofocus="true"></el-input>
                                    <span v-if="!scope.row.editing">{{scope.row.title}}</span>
                                </div>
                            </template>

                        </el-table-column>

                        <el-table-column prop="action" label="操作">
                            <template scope="scope" style="width: 100px">
                                <el-button v-if="!scope.row.editing" @click="onClickRowEdit(scope.row)" size="mini">编辑</el-button>
                                <el-button v-if="scope.row.editing" @click="onClickRowCompleteEdit(scope.$index, scope.row)" size="mini" type="primary" :ref="'confirm_' + scope.row.viewId" :loading="scope.row.loading">确认</el-button>
                                <el-button v-if="scope.row.editing" @click="onClickRowCancelEdit(scope.$index, scope.row)" size="mini">取消</el-button>
                                <el-button v-if="!scope.row.editing" @click="onClickRowDelete(scope.$index, scope.row)" size="mini" type="danger">删除</el-button>
                                <el-button v-if="!scope.row.isResource && !scope.row.editing" @click="onClickAddChild(scope.$index, scope.row)" size="mini">添加子节点</el-button>
                                <el-button v-if="!scope.row.isResource && !scope.row.editing" @click="onClickAttachResource(scope.$index, scope.row)" size="mini">挂载资源</el-button>
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
    
    .el-pagination {
        text-align: center;
    }
</style>
<script>
    import ResourceChoiceComponent from './ResourceChoiceComponent'
    import ResourceSelectComponent from './ResourceSelectComponent'
    import TableOfContentViewModel from "./view/model/TableOfContentViewModel";
    import TableOfContentDTOAssembler from "./remote/TableOfContentDTOAssembler";
    import ResourceViewModel from "./view/model/ResourceViewModel";

    export default {
        components: {
            'resource-choice': ResourceChoiceComponent,
            'resource-select': ResourceSelectComponent
        },

        props: {
            id: {
                type: String
            },
            tableOfContentEditing: {
                type: Function
            },
            tableOfContentDeleting: {
                type: Function
            },

            resourceLoading: {
                type: Boolean,
                default: false
            },

            resources: {
                type: Array,
                default: () => {
                    return []
                }
            },

            resourceSelect: {
                type: Function
            },

            resourceSelected: {
                type: Function,
                default: () => {
                    return async () => {
                        console.debug('resource-selected is not set')
                    }
                }
            },

            beforeUpload: {
                type: Function,
                default: () => {
                    return async () => {
                        console.debug('before-upload is not set')
                    }
                }
            },

            uploadHttpRequest: {
                type: Function,
                default: () => {
                    return async () => {
                        console.debug('upload-http-request is not set')
                    }
                }
            },

            pageTotal: {
                type: Number,
                default: 20
            },

            pageSize: {
                type: Number,
                default: 2
            },

            pageChange: {
                type: Function,
                default: () => {
                    return async () => {
                        console.debug('page-change is not set')
                    }
                }
            },

            form: {
                type: Object,
                default() {
                    return {
                        title: '',
                        description: '',
                        tableOfContents: []
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
                ],
                uploadURL: '',
                accessKey: '',
                signature: '',
                policy: '',
                uploadingResource: null,
                activeName: "tableOfContents",
                loading: false,

                /**
                 * 资源挂载弹层的加载状态
                 */
                attachResourceDialogLoading: false
            }
        },

        created() {
            // this.resourceVisible = true

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

            onClickTabResourceList() {

                if ('choice' == this.attachResourceActiveName &&
                    this.resourceSelect) {

                    this.resourceSelect()
                }
            },

            onResourceSelectChanged(e) {
                console.debug(e)
            },

            async onClickAttachResourceConfirm() {
                const selected = this.resources
                    .filter((resource) => {
                        if (resource.chosen)
                            return resource
                    })
                    .map((resource) => {
                        return new TableOfContentViewModel(
                            null,
                            resource.title,
                            this.chooseAttachTOC.depth + 1,
                            false,
                            resource
                        )
                })


                if (this.resourceSelected) {
                    this.attachResourceDialogLoading = true

                    const interrupt = !this.resourceSelected(
                        this.chooseAttachTOC,
                        selected
                    )
                    this.attachResourceDialogLoading = false
                    if (interrupt) {
                        return
                    }

                    selected.forEach((toc) => {
                        this.addChild(
                            this.chooseAttachTOCIndex,
                            this.chooseAttachTOC,
                            toc
                        )
                    })

                }

                this.resourceVisible = false
            },

            tableOfContentWithResource(parent, resource) {
                return new TableOfContentViewModel(
                    null,
                    resource.title,
                    parent.depth + 1,
                    false,
                    resource
                )
            },

            onUploadPreview(file) {
                console.debug(file)
            },

            onExceed(file, fileList) {
                console.debug(file)
                console.debug(fileList)
            },


            onClickAttachResource(index, row) {
                this.chooseAttachTOC = row
                this.chooseAttachTOCIndex = index
                this.resourceVisible = true
            },

            async onClickRowDelete(index, row) {
                // row.loading = true
                // this.$refs['confirm_' + row.viewId].loading = true

                if (this.tableOfContentDeleting) {
                    await this.tableOfContentDeleting(row)
                }

                this.findAndDeleteRangeByStart(index)

                // row.loading = false
                // this.$refs['confirm_' + row.viewId].loading = true
            },

            findAndDeleteRangeByStart(start) {
                const toc = this.form.tableOfContents[start]
                var end = -1
                for (var i = start + 1, size = this.form.tableOfContents.length; i < size; i++) {
                    const pick = this.form.tableOfContents[i];
                    if (pick.depth <= toc.depth) {
                        end = i
                        break
                    }
                }

                if (end == -1)
                    end = this.form.tableOfContents.length

                const deleted = this.form.tableOfContents.splice(
                    start,
                    end - start
                )

                return deleted
            },

            async onClickRowCompleteEdit(index, row) {
                row.inputFocus = false
                row.title = row.typingTitle
                row.loading = true
                this.$refs['confirm_' + row.viewId].loading = true

                if (this.tableOfContentEditing) {
                    await this.tableOfContentEditing(
                        row,
                        this.findParent(index, row)
                    )
                }

                this.$refs['confirm_' + row.viewId].loading = false
                row.loading = false
                row.editing = false
            },

            findParent(index, row) {
                if (row.depth == 0)
                    return null

                for (var i = index - 1; i > -1; i--) {
                    const previous = this.form.tableOfContents[i]
                    if (previous.depth < row.depth)
                        return previous
                }
                return null
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