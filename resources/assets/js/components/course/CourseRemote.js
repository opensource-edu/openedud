export default class CourseRemote {
    constructor(http) {
        this.http = http
    }

    async fetchOne(id) {
        const response = await this.http.get(`/api/course/${id}`)
        return response.data
    }
}