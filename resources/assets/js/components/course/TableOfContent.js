import Node from "./Node";

export default class TableOfContent extends Node {
    constructor(id, title, depth, children, resource) {
        super(id, depth, children)

        this.title = title
        this.resource = resource
    }
}