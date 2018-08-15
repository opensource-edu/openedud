<template>


    <el-container>
        <el-dialog
                title="添加课程"
                :visible.sync="courseDialogVisible"
                width="60%"
                center
        >

                <AddCourse></AddCourse>

            <span slot="footer" class="dialog-footer">
            <el-button @click="dialogVisible = false">取 消</el-button>
            <el-button type="primary" @click="dialogVisible = false">确 定</el-button>
          </span>
        </el-dialog>

        <el-row>
            <el-col :span="24">
                <el-button>添加新课程</el-button>
            </el-col>
        </el-row>
        <el-row>
            <el-col :span="24" >
                <el-table
                        :data="courses"
                        border
                        style="width: 100%">
                    <el-table-column
                            prop="title"
                            label="课程名字"
                            width="500">
                    </el-table-column>
                    <el-table-column
                            prop="created_at"
                            label="日期"
                            width="180">
                    </el-table-column>
                    <el-table-column>
                        <template slot-scope="scope">
                            <el-button size="small">编辑</el-button>
                        </template>
                    </el-table-column>

                </el-table>
            </el-col>
        </el-row>
    </el-container>


</template>
<style>
    .el-dialog {
        width: 80%;
    }
</style>
<script>
    import AddCourse from "./AddCourse.vue"

    export default {
        components: {
            AddCourse
        },

        async mounted() {
            const response = await this.$http.get('/api/courses')
            console.debug(response)

            this.courses = response.body.data
        },

        data() {
            return {
                courses: [],
                courseDialogVisible: true
            }
        },
        methods: {
            onSubmit() {
                console.log('submit!');
            }
        }
    }
</script>
