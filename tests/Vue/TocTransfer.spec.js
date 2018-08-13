import TocTransfer from '../../resources/assets/js/TocTransfer.js'

describe("1", () => {
    it("2", () => {
        const transfer = new TocTransfer()
        const toc = transfer.toTree([
            {
                id: 1,
                title: '1',
                depth: 1
            },
            {
                title: "1.1",
                depth: 2
            },
            {
                title: "1.1.1",
                depth: 3
            },
            {
                title: '2',
                depth: 1
            },
            {
                title: '2.2',
                depth: 2
            }
        ])
        console.debug('tocs')
        console.debug(JSON.stringify(toc))
    })
})