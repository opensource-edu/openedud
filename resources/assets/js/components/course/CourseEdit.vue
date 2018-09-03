<template>
    <CourseForm
        :table-of-content-editing="onTableOfContentEditing"
        :table-of-content-deleting="onTableOfContentDeleting"
        :resource-select="onResourceSelect"
        :resource-selected="onResourceSelected"
        :before-upload="onBeforeUpload"
        :upload-http-request="onUploadHttpRequest"
        :form="this.course"
        :resources="resources"
        :page-total="resourcePageTotal"
        :page-size="resourcePageSize"
        :page-change="pageChange"
        :resource-loading="resourceLoading"
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
                resources: [],
                resourceLoading: false,
                resourcePageTotal: 0,
                certificate: null
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
                await this.loadResourceList(1)
            },

            async pageChange(page) {
                await this.loadResourceList(page)
            },

            async loadResourceList(page) {
                this.resourceLoading = true
                const resourceList = await this.remote.fetchResourceListTop10(page)
                this.resources = this
                    .resourceViewModelAssembler
                    .toViewModelList(resourceList.data)
                this.resourcePageTotal = resourceList.total
                this.resourcePageSize = resourceList.per_page
                this.resourceLoading = false
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

                this.certificate = {
                    url: response.data.upload_url,
                    signature: response.data.signature,
                    accessKey: response.data.signature,
                    policy: response.data.policy,
                    key: response.data.object_path,
                    resourceId: response.data.resource.id
                }
            },

            async onUploadHttpRequest(request) {
                const formData = new FormData()

                formData.append('key', this.certificate.key)
                formData.append('file', request.file)
                formData.append('OSSAccessKeyId', this.certificate.accessKey)
                formData.append('policy', this.certificate.policy)
                formData.append('signature', this.certificate.signature)

                await this.$http.post(this.certificate.url, formData)
                const response = await this.$http.put(
                    `/api/resource/${this.certificate.resourceId}/status`,
                    {
                        'status': 'available'
                    }
                )
            }
        }
    }
</script>

<style scoped>

</style>