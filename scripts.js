function addGroupCondition(group_id){
    const condition_template = document.getElementById("condition-template");

    const new_condition_element = condition_template.cloneNode(true);

    const group_element = document.getElementById("group-" + group_id);

    const all_conditions_element = group_element.querySelector(".ws-group-type-conditions");

    all_conditions_element.appendChild(new_condition_element);
}