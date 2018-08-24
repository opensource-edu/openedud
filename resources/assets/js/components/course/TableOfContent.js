export default class TableOfContent {
    constructor(title, resource, depth) {
        this.title = title
        this.editing = false
        this.inputFocus = false
        this.resource = resource
        this.isResource = resource != null
        this.depth = depth
    }
}