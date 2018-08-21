export default class TocTransfer {
    toTree(tableOfContents) {
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

        const clearTree = function(tree) {
            for (var node of tree) {
                if (node.children.length > 0) {
                    clearTree(node.children)
                }

                delete node.parent
            }
        }

        clearTree(contents)

        return contents
    }
}