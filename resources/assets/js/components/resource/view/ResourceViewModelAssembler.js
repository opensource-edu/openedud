import ResourceViewModel from "../../course/view/model/ResourceViewModel";

export default class ResourceViewModelAssembler {
    toViewModelList(resourceList) {
        return resourceList.map((resource) => {
            return this.toViewModel(resource)
        })
    }

    toViewModel(resource) {
        return new ResourceViewModel(
            resource.id,
            resource.title,
            false
        )
    }
}