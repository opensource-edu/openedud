import TocTransfer from '../../resources/assets/js/TocTransfer.js'

const expect = require('chai').expect

describe("TocTransfer", () => {
    it("should return a tree", () => {
        const transfer = new TocTransfer()
        const toc = transfer.toTree([
            {
                id: 1,
                title: 'Chapter 1',
                depth: 0
            },
            {
                id: 2,
                title: "Section 1.1",
                depth: 1
            },
            {
                id: 3,
                title: "Section 1.1.1",
                depth: 2
            },
            {
                id: 10,
                title: "资源",
                depth: 3
            },
            {
                id: 4,
                title: 'Chapter 2',
                depth: 0
            },
            {
                id: 5,
                title: 'Section 2.1',
                depth: 1
            }
        ])

        expect(toc[0].id).to.equal(1)
        expect(toc[0].title).to.equal('Chapter 1')

        expect(toc[0].children[0].id).to.equal(2)
        expect(toc[0].children[0].title).to.equal('Section 1.1')
        expect(toc[0].children[0].depth).to.equal(1)

        expect(toc[0].children[0].children[0].id).to.equal(3)
        expect(toc[0].children[0].children[0].title).to.equal('Section 1.1.1')
        expect(toc[0].children[0].children[0].depth).to.equal(2)

        expect(toc[1].id).to.equal(4)
        expect(toc[1].title).to.equal('Chapter 2')

        expect(toc[1].children[0].id).to.equal(5)
        expect(toc[1].children[0].title).to.equal('Section 2.1')
        expect(toc[1].children[0].depth).to.equal(1)
    })

    it('should return a flat array', () => {
        const aTree = {
            'title': 'Chapter 1',
        }
    })
})