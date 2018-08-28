export default class TableOfContentViewModel {
    constructor(id, title, depth, editing, resource) {
        this.id = id
        this.title = title
        this.depth = depth
        this.editing = editing
        this.inputFocus = false
        this.resource = resource
        this.isResource = null != resource

        this.typingTitle = title
        this.viewId = id || Math.random()
    }
}