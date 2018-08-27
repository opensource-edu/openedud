<template>
    <CourseForm
        :table-of-content-editing="onTableOfContentEditing"
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
            this.serviceFacade = new CourseServiceFacade(remote)

            this.course = await this.serviceFacade.fetchOne(this.$route.params.id)
        },

        methods: {
            async onTableOfContentEditing(tableOfContent) {

                return new Promise((resolve, reject) => {
                    setTimeout(() => {
                        resolve()
                    }, 1000)
                })

            }
        }
    }
</script>

<style scoped>

</style>