function is_exist(field_id,field_name,field_value,table_name,url)
{
	// check if not empty
	if(field_id =='' || field_name == '' || field_value == '' || table_name == '' || url == '')
	{
		return false;
	}
	else
	{
		$("#"+field_id).next('span').remove();
	
		$.ajax({
			url: url,
			type: "post",
			data:{ 'field_name' : field_name, 'field_value' : field_value, 'table_name' : table_name },
			success:function(resp)
			{
				if(resp == 1)
				{
					$("#"+field_id).after("<span style='color:red'><b> Already Exist. </b></span>");
				}
				else
				{
					$("#"+field_id).after("<span style='color:green'><b> Available. </b></span>");
				}				
			},
			error:function()
			{
				// error	
			}
		});
	}
}

function get_data(field_id,get_field,field_name,field_value,table_name,field_type,url)
{
	// check if not empty
	if(field_id =='' || get_field =='' || field_name == '' || field_value == '' || table_name == '' || field_type == '' || url == '')
	{
		return false;
	}
	else
	{
		$.ajax({
			url: url,
			type: "post",
			data:{ 'get_field' : get_field, 'field_name' : field_name, 'field_value' : field_value, 'table_name' : table_name, 'field_type' : field_type },
			success:function(resp)
			{
				//alert(resp);
				
				if(field_type == 'text')
				{	
					$('#'+field_id).val('');
				
					$('#'+field_id).val(resp);
				}
				else
				{
					$('#'+field_id).empty();
					
					$('#'+field_id).append(resp);
				}
			},
			error:function()
			{
				// error	
			}
		});
	}
}

// get table for selected value -
function get_table(column_names,db_column_names,field_name,field_value,table_name,url)
{
	if(column_names =='' || db_column_names =='' || field_name == '' || field_value == '' || table_name == '' || url == '')
	{
		return false;
	}
	else
	{
		// empty div -
		$('#dynamic').empty();
		
		$.ajax({
				url: url,
				type: "post",
				async:false,
				cache:false,
				dataType:'json',
				data: { 'column_names' : column_names, 'db_column_names' : db_column_names, 'field_name' : field_name, 'field_value' : field_value, 'table_name' : table_name },
				success: function (data) {
					// append table to div -
					$('#dynamic').append(data);
				}
		});
	}
}