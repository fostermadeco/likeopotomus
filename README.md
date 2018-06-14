# Likeopotomus

Add-on for Expression Engine to handle bookmarking and liking of content

## Module - Available Tags

```
{exp:likeopotomus:tag}
```
Auto generates a link to either add or delete a record.

Required parameters:
* `type` : "like" or "bookmark"
* `item_id` : unique key for current item, such as entry_id, comment_id, etc
* `item_type` : custom input - use this to define if it is an entry, comment, etc

Optional parameters:
* `class` : used to apply css styles to rendered tag
* `add_text` : customizes displayed text for adding an item
* `delete_text` : customizes displayed text for deleting an item

```
{exp:likeopotomus:count}
```
Outputs the number of likes / bookmarks an item has

Required parameters:
* `type` : "like" or "bookmark"
* `item_id` : unique key for current item, such as entry_id, comment_id, etc
* `item_type` : custom input - use this to define if it is an entry, comment, etc

```
{exp:likeopotomus:mine} {/exp:likeopotomus:mine}
```
Used to create {ids} template variable, a string of item ids separated by a "|" for use with ExpressionEngine tags.

Required parameters:
* `type` : "like" or "bookmark"

## Extension - Modifications to Channel Entries Query Results

Required parameters:
* `likes_type` : "like" or "bookmark"
* `item_type` : type of item being retrieved in the query

Parameters are added to the `{exp:chanel:entries}` opening tag. This will add the `{is_saved}` boolean, as well as the `{qstring}` string variable.