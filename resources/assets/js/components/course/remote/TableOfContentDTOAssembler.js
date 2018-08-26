export default class TableOfContentDTOAssembler {

    toTableOfContentDTO(tableOfContent) {

    }

    toTableOfContentDTOList(tableOfContentList) {
        const walk = function(tableOfContentList) {

        }

        const self = this
            , tableOfContentDTOList = []
        walk((tableOfContent, parent) => {
            const tableOfContentDTO = new TableOfContentDTO()
            if (null == parent) {
                tableOfContentDTOList.push(tableOfContentDTO)
            } else {
                const parentDTO = null
                parentDTO.addChild(tableOfContentDTO)
            }
        })

        return tableOfContentDTOList
    }
}