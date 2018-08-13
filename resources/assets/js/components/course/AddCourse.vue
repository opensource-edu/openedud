<template>
    <el-card class="box-card">
        <div slot="header" class="clearfix">
            <span>添加课程</span>
        </div>

        <el-form ref="form" :model="form" label-width="80px">
            <el-form-item label="课程名称">
                <el-input v-model="form.name" placeholder="请输入课程名称"></el-input>
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

            <el-form-item label="课程大纲">
                <el-table :data="form.toc" border>
                    <el-table-column
                        prop="title"
                        label="标题">

                        <template scope="scope">
                            <div :style="{marginLeft: (scope.row.depth * 10 ) + 'px'}">
                                <el-input v-if="scope.row.editing" v-model="scope.row.title" :focus="scope.row.inputFocus" @keyup.enter.native="onRowCompleteEdit(scope.row)" placeholder="请输入标题"></el-input>
                                <span v-if="!scope.row.editing">{{scope.row.title}}</span>
                            </div>
                        </template>

                    </el-table-column>

                    <el-table-column prop="action" label="操作">
                        <template scope="scope" style="width: 100px">
                            <el-button v-if="!scope.row.editing" @click="onRowEdit(scope.row)" size="small">编辑</el-button>
                            <el-button v-if="scope.row.editing" @click="onRowCompleteEdit(scope.row)" size="small" type="primary">确认</el-button>
                            <el-button v-if="scope.row.editing" @click="onRowCancelEdit(scope.row)" size="small">取消</el-button>
                            <el-button @click="onAddChild(scope.$index, scope.row)" size="small">添加子节点</el-button>
                        </template>
                    </el-table-column>

                </el-table>
            </el-form-item>

            <el-form-item>
                <el-button type="primary" @click="onSubmit">立即创建</el-button>
                <el-button>取消</el-button>
            </el-form-item>
        </el-form>

    </el-card>
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
</style>
<script>
    export default {
        data() {
            return {
                test: 10,
                form: {
                    name: '',
                    description: '',
                    imageURL: '',
                    toc: [
                        {
                            title: "Chapter 1",
                            editing: false,
                            inputFocus: false,
                            depth: 1
                        },
                        {
                            title: "Chapter 2",
                            editing: false,
                            inputFocus: false,
                            depth: 1
                        },
                    ]

                }
            }
        },


        methods: {
            onRowCompleteEdit(row) {
                row.editing = false
                row.inputFocus = false
                console.debug(row)
            },

            onRowCancelEdit(row) {
                row.editing = false
                row.inputFocus = false
            },

            onRowEdit(row) {
                console.debug(row)
                row.editing = true
                row.inputFocus = true
            },

            onAddChild(index, parent) {
                var foundIndex = -1
                console.debug(`select index ${index}`)
                // debugger
                // const next = this.form.toc[index + 1]
                // if (next) {
                //     console.debug('next')
                //     console.debug(JSON.stringify(next))
                //     console.debug(JSON.stringify(parent))
                //     if (next.depth < parent.depth) {
                //         foundIndex = index + 1
                //         console.debug(foundIndex)
                //     }
                // }

                if (-1 === foundIndex) {
                    for (var i = index + 1, size = this.form.toc.length; i < size; i++) {
                        const found = this.form.toc[i]
                        console.debug(`search index ${i} depth ${found.depth} parent ${parent.depth} title ${found.title}`)

                        if (parent.depth === found.depth) {
                            console.debug('search complete')
                            foundIndex = i
                            break
                        }
                    }
                }

                if (-1 === foundIndex) {
                    foundIndex = this.form.toc.length
                }

                console.debug(`found index ${foundIndex}`)

                this.form.toc.splice(foundIndex, 0, {
                    title: "",
                    editing: true,
                    inputFocus: true,
                    depth: parent.depth + 1,
                    parent: parent.id
                })
            },

            onSubmit() {


                const toc = toTree(this.form.toc)
                console.log('submit!');
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