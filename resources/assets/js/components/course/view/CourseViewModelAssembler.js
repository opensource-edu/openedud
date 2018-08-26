import CourseViewModel from './model/CourseViewModel'
import TableOfContentViewModel from "./model/TableOfContentViewModel";

export default class CourseViewModelAssembler {
    toViewModel(course) {
        const viewModel = new CourseViewModel(
            course.id,
            course.title,
            course.description,
            this.toTableOfContentViewModelList(course.table_of_contents)
        )

        return viewModel
    }

    toTableOfContentViewModel(tableOfContent) {
        return new TableOfContentViewModel(
            tableOfContent.id || 0,
            tableOfContent.title,
            parseInt(tableOfContent.depth)
        )
    }

    // toResourceViewModel(resource) {
    //     return new ResourceViewModel()
    // }

    toTableOfContentViewModelList(tableOfContents) {
        const self = this
        const walk = function(nodes) {
            var flat = []
            nodes.forEach((node) => {

                flat.push(self.toTableOfContentViewModel(node))
                if (node.children && node.children.length > 0) {
                    const children = walk(node.children)
                    flat = flat.concat(children)
                }
            })
            return flat
        }
        const vm = walk(tableOfContents)
        return vm
    }

    toTableOfContents(tableOfContents) {
        var contents = []
            , previous = null


        for (var content of tableOfContents) {
            var isChildByPrevious = false
                , isSibilingByPrevious = false

            const node = {
                id: content.id,
                title: content.title,
                parent: null,
                children: [],
                depth: content.depth
            }

            if (previous === null) {
                previous = node
                contents.push(node)
                continue
            }

            if (content.depth === previous.depth) {
                isSibilingByPrevious = true
            } else if (content.depth > previous.depth) {
                isChildByPrevious = true
            } else if (content.depth < previous.depth) {
                contents.push(node)
            }

            if (isChildByPrevious) {
                node.parent = previous
                previous.children.push(node)
            }

            if (isSibilingByPrevious) {
                if (previous.parent) {
                    previous.parent.children.push(node)
                } else {
                    contents.push(node)
                }
            }

            previous = node
        }

        return contents
    }
}