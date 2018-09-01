export default class CourseRemote {
    constructor(http) {
        this.http = http
    }

    async fetchOne(id) {
        const response = await this.http.get(`/api/course/${id}`)
        return response.data
    }

    async storageTableOfContent(courseId, id, parentId, title) {
        var requestData = {
            title: title,
            parent_id: parentId,
            id: id
        }
        const response = await this.http.put(
            `/api/course/${courseId}/table-of-content`,
            requestData
        )

        return response.data
    }

    async batchStorageTableOfContent(parentId, command) {
        const response = await this.http.post(
            `/api/table-of-content/${parentId}`,
            command
        )

        return response.data
    }

    async deleteTableOfContent(courseId, tocId) {
        const response = await this.http.delete(
            `/api/course/${courseId}/table-of-content/${tocId}`
        )
        return response.data
    }

    async fetchResourceListTop10() {
        const response = await this.http.get(
            `/api/resource`
        )

        return response.data
    }
}