// all based on returning graphQL JSON
{
    node_id : '23',
    title: 'Profile',
    data: { 
        'First Name' :  {
            {}
            {}
        }
        'Last Name' : {

        }
    }
}

// graphql
$profiles = content('{
    Profiles(first:2){
        edges {
            node {
                name
            }
            cursor
        }
    }
}');

///////////////////////////////////////////////////////////////

group
    group_id, name, NOW()

group_user

    id, group_id, user_id
    
user
    id, name, last_modified_user_id, NOW()
    id, {}

tag

    id, type_id, tag_id
    1, 1, 1

// structure of type
content_type_schema
    type_id, parent_id, name, machine_name, default_value, handler_id, description, timestamp
    1, 0, 'Profiles', 'profiles' '{s:Select}', 2, NOW()
    2, 0, 'Files', FILE\
    3, 0, 'Blurbs'
    4, 0, 'Stories'
    1, 1, 'First Name', 1, 'Enter your first name', NOW()
    1, 1, 'Last Name', 1, 'Enter your last name', NOW()

// done by api
content_type_handler 

    handler_id, name, namespace, hooks
    1, 'Select', 'HTML\Select', [onDisplay, onEdit, onLoad]
    2, 'Video', 'HTML\VideoEmbed' 

        onDisplay {
            <select name="">
                foreach($value){
                    <option value=""></option>
                }
            </select>
        }
        onEdit {}
        onLoad {}

content_type_entity
    
    id, type_id, version_id, group_id, user_id, timestamp
    1, 1, 1, 1 NOW()

    // only parents can feature tags
    content_type_entity_tag

        tag_id, name
        1, 'Grease'

    content_type_entity_value

        schema_id
        
        id, type_id, version_id, serialized_value, lastmod_user_id, timestamp
        1, 1, 2, '{s:2,b:3}', 1
        2, 1, 1, '{s:Help,b:Cat,c:Dog}', 1
        3, 1, 1, '{image:213,author:'Ken'}

    content_type_entity_value_revision
        revision, id, value, user_id, timestamp
    
// allows for inherited ACL
content_type_group_access

    id, type_id, ++++++++++----------------------------------------------------------------------------------------------------------------------------------------------------------group_id, permission {enum: select, insert, update, delete}, timestamp
    1, 1, 1, 0, 1, 0, 1, NOW()
