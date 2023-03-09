//--Typedefs--//

/**
 * Subelements of a group
 * @typedef {object} group_list_item_elements
 * @property {Element} name - Name element
 * @property {Element} conditions - Conditions list element
 * @property {Element} add_condition_button - "Add condition" button
 * @property {Element} condition_type - "Condition type" input element
 */

//--Functions--//

function addGroupCondition(group_id){
    const condition_template = document.getElementById("condition-template");

    const new_condition_element = condition_template.cloneNode(true);

    const group_element = document.getElementById("group-" + group_id);

    const all_conditions_element = group_element.querySelector(".ws-group-item-conditions");

    all_conditions_element.appendChild(new_condition_element);
}



/**
 * Get subelements of a group, such as the name element, conditions list element, etc.
 * @param {Element} group_list_item 
 * @returns {group_list_item_elements} An object containing the group's editable subelements
 */
function getGroupListItemElements(group_list_item){
    let output = {};

    output.name = group_list_item.querySelector(".ws-group-name");
    output.add_condition_button = group_list_item.querySelector(".ws-group-add-condition-button");
    output.condition_type = group_list_item.querySelector(".ws-condition-type");

    return output;
}
/**
 * Get a group id that hasn't been taken
 * @param {Element} groups_list_element 
 * @returns Group id that hasn't been taken
 */
function getUntakenGroupId(groups_list_element){
    //The untaken id.
    let untaken_id = -1;
    //Whether an untaken id has been foudn
    let found_untaken_id = false;
    //Iterate over all groups until an untaken id has been found
    while(!found_untaken_id){
        //Increment the id until an untaken id has been found
        untaken_id++;
        found_untaken_id = true;
        //Itarate over all groups to see if the current untaken_id is taken
        for(const group of groups_list_element.children){
            //If id is taken, break the loop and increment the untaken_id, and repeat the process
            if(group.dataset.id == untaken_id){
                found_untaken_id = false;
                break;
            }
        }
    }
    //Return the untaken id
    return untaken_id;
}

/**
 * Add a group to the sale's groups list
 * @param {object | null} [data=null] Group data. Set to null if adding new group instead of an existing one
 * @param {string | number} data.id Id of group. Required if adding existing group
 * @param {string} data.name Group name. Required if adding existing group
 */
function addGroup(data = null){
    const group_template = document.getElementById("group-list-item-template");

    const new_group_element = group_template.cloneNode(true);

    const groups_list_element = document.getElementById("groups-list");

    //Default data, for when data is not specified
    const default_data = {
        name: "New group"
    }

    //If data is not specified, use default data
    if(!data){
        data = default_data;
        data.id = getUntakenGroupId(groups_list_element);
        new_group_element.id = `group-${data.id}`;
    }

    new_group_element.id = `group-${data.id}`;
    //console.log(data.id);
    new_group_element.dataset.id = data.id;

    const group_subelements = getGroupListItemElements(new_group_element);

    group_subelements.name.innerHTML = data.name;

    // Attach event listeners
    group_subelements.add_condition_button.addEventListener("click", () => {
        addGroupCondition(data.id);
    })
    group_subelements.condition_type.addEventListener("change", handleConditionTypeChange);

    //Append the newly added group to the groups list
    groups_list_element.appendChild(new_group_element);
}

function handleConditionTypeChange(e){
    console.log(e);
}

function loadSaleEditPage(){
    addGroup();
    addGroup();
    addGroup();
    addGroup();
}