export default class TocTransfer {
    toTree(tableOfContents) {
        var contents = []
            , previous = null


        for (var content of tableOfContents) {
            var isChildByPrevious = false
                , isSibilingByPrevious = false

            const node = {
                title: content.title,
                parent: null,
                children: [],
                depth: content.depth
            }

            if (previous === null) {
                console.debug('previous is null')
                previous = node
                contents.push(node)
                continue
            }

            console.debug('content')
            console.debug(content)
            console.debug('previous')
            console.debug(previous)
            if (content.depth === previous.depth) {
                console.debug('content is sibiling')
                isSibilingByPrevious = true
            } else if (content.depth > previous.depth) {
                console.debug('content is child')
                isChildByPrevious = true
            } else if (content.depth < previous.depth) {
                contents.push(node)
            }

            if (isChildByPrevious) {
                console.debug('is child')
                // console.debug(previous)

                node.parent = previous
                previous.children.push(node)
                console.debug(previous)
            }

            if (isSibilingByPrevious) {
                console.debug('is sibiling')
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
                console.debug('clear tree')
                console.debug(node)
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