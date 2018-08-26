export default class TocTransfer {


    toFlat(nodes) {
        const walk = function(nodes) {
            var flat = []
            nodes.forEach((node) => {
                flat.push(node)
                if (node.children && node.children.length > 0) {
                    flat = flat.concat(walk(node.children))
                }
            })
            return flat
        }
        return walk(nodes)
    }
}