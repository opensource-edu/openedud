import TableOfContentDTO from "./TableOfContentDTO";

export default class TableOfContentDTOAssembler {

    toTableOfContentDTO(tableOfContent) {

    }

    /**
     *
     * @param tableOfContentList
     * @return TableOfContentDTO
     */
    toTableOfContentDTOList(tableOfContentList) {
        const walk = function(tableOfContentList, parent) {
            const tableOfContentDTOList = []
            tableOfContentList.forEach((tableOfContent) => {

                const tableOfContentDTO = new TableOfContentDTO(
                    tableOfContent.id,
                    tableOfContent.title
                )
                tableOfContentDTOList.push(tableOfContentDTO)

                if (tableOfContent.children && tableOfContent.children.length > 0) {
                    const children = walk(tableOfContent.children, tableOfContent)
                    tableOfContentDTO.children = children
                }
            })
            return tableOfContentDTOList
        }
        return walk(tableOfContentList, null)
    }
}