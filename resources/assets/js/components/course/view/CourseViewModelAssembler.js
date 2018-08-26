import CourseViewModel from './model/CourseViewModel'
import TableOfContentViewModel from "./model/TableOfContentViewModel";

export default class CourseViewModelAssembler {
    toViewModel(course) {
        const viewModel = new CourseViewModel(
            course.id,
            course.title,
            this.toTableOfContentViewModelList(course.table_of_contents)
        )

        return viewModel
    }

    toTableOfContentViewModel(tableOfContent) {
        return new TableOfContentViewModel(
            tableOfContent.id, tableOfContent.title, parseInt(tableOfContent.depth)
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
}