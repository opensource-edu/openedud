<template>
    <CourseForm
        :table-of-content-editing="onTableOfContentEditing"
        :table-of-content-deleting="onTableOfContentDeleting"
        :resource-select="onResourceSelect"
        :resource-selected="onResourceSelected"
        :form="this.course"
        :resources="resources"
            v-bind:id="this.$route.params.id">

    </CourseForm>
</template>

<script>
    import CourseForm from './CourseForm'
    import CourseServiceFacade from "./CourseServiceFacade"
    import CourseRemote from "./CourseRemote"
    import ResourceViewModelAssembler from "../resource/view/ResourceViewModelAssembler";

    export default {
        components: {
            CourseForm
        },

        data() {
            return {
                course: null,
                resources: []
            }
        },

        async created() {
            const remote = new CourseRemote(this.$http)
            this.remote = remote
            this.serviceFacade = new CourseServiceFacade(remote)
            this.resourceViewModelAssembler = new ResourceViewModelAssembler()

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
                await this.remote.deleteTableOfContent(
                    this.courseId,
                    tableOfContent.id
                )
            },

            async onResourceSelect() {
                const resourceList = await this.remote.fetchResourceListTop10()
                this.resources = this
                    .resourceViewModelAssembler
                    .toViewModelList(resourceList)
            },

            async onResourceSelected(parent, tableOfContents) {
                try {
                    const tableOfContentListCommand = tableOfContents.map((tableOfContent) => {
                        return {
                            title: tableOfContent.title,
                            resource_id: tableOfContent.resource.id
                        }
                    })
                    await this.remote.batchStorageTableOfContent(
                        parent.id,
                        tableOfContentListCommand
                    )
                    return true
                } catch (e) {
                    debugger
                    return false
                }
            }
        }
    }
</script>

<style scoped>

</style>