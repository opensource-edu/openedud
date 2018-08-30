<template>
    <CourseForm
        :table-of-content-editing="onTableOfContentEditing"
        :table-of-content-deleting="onTableOfContentDeleting"
        :form="this.course"
            v-bind:id="this.$route.params.id">

    </CourseForm>
</template>

<script>
    import CourseForm from './CourseForm'
    import CourseServiceFacade from "./CourseServiceFacade"
    import CourseRemote from "./CourseRemote"

    export default {
        components: {
            CourseForm
        },

        data() {
            return {
                course: null
            }
        },

        async created() {
            const remote = new CourseRemote(this.$http)
            this.remote = remote
            this.serviceFacade = new CourseServiceFacade(remote)

            this.course = await this.serviceFacade.fetchOne(this.$route.params.id)
        },

        computed: {
            courseId() {
                return this.$route.params.id
            }
        },

        methods: {
            async onTableOfContentEditing(tableOfContent, parent) {

                return new Promise((resolve, reject) => {
                    this.remote.storageTableOfContent(
                        this.courseId,
                        tableOfContent.id,
                        parent ? parent.id : null,
                        tableOfContent.title
                    )
                    resolve()
                })

            },

            async onTableOfContentDeleting(tableOfContent) {
                await this.remote.deleteTableOfContent(this.courseId, tableOfContent.id)
            }
        }
    }
</script>

<style scoped>

</style>