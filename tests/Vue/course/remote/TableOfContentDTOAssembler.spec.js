import TableOfContentDTOAssembler from "../../../../resources/assets/js/components/course/remote/TableOfContentDTOAssembler";

const expect = require('chai').expect

describe("TocTransfer", () => {
    it("should return a tree", () => {
        const assembler = new TableOfContentDTOAssembler()
        const toc = assembler.toTableOfContentDTOList([
            {
                title: 'Chapter 1',
                children: [
                    {
                        title: 'Section 1.1'
                    },
                    {
                        title: 'Section 1.2',
                        children: [
                            {
                                title: 'Section 1.2.1'
                            }
                        ]
                    }
                ]
            },
            {
                title: 'Chapter 2',
                children: [
                    {
                        title: 'Section 2.1'
                    }
                ]
            }
        ])

        expect(toc[0].children[0].title).to.equal('Section 1.1')
        expect(toc[0].children[1].children[0].title).to.equal('Section 1.2.1')

    })
})