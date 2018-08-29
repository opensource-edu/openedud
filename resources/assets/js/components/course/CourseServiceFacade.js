import CourseViewModelAssembler from './view/CourseViewModelAssembler'

export default class CourseServiceFacade {
    constructor(remote) {
        this.remote = remote
        this.assembler = new CourseViewModelAssembler()
    }

    async fetchOne(id) {
        const course = await this.remote.fetchOne(id)
        const viewModel = this.assembler.toViewModel(course)
        return viewModel
    }

    async storageTableOfContent(course, parent, title) {
        return await this.remote.storageTableOfContent(
            course.id,
            parent.id,
            title
        )
    }
}