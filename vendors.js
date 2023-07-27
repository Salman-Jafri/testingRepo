$(document).ready(function() {



	$('#dt').DataTable({

		serverSide: true,

		responsive: true,

		"pageLength" :10,

		"order": [

			[0, "asc" ]

		],

		"ajax": {

			url :'showVendors',

			type : 'POST'

		},

		dom: "<'row'<'col-sm-12 col-lg-4'l><'col-sm-12 col-lg-4'B><'col-sm-12 col-lg-4'f>>"+

				 "<'row'<'col-12'rt>>"+

				 "<'row'<'col-12'i>>"+

				 "<'row'<'col-12'p>>",

    buttons: [

        'copy', 'excel', 'pdf'

    ],

    language: {

      paginate: {

        next: '&#8594;', // or '→'

        previous: '&#8592;' // or '←' 

      }

    }

		

		

	     

  });    

// 	$('#dt').DataTable({

// 		serverSide: true,

// 		responsive: true,

// 		"pageLength" :10,

// 		"order": [

// 			[0, "asc" ]

// 		],

// 		"ajax": {

// 			url :'showVendors',

// 			type : 'POST'

// 		},

//       "fnInitComplete": function(oSettings, json) {

          

//           $('#dt').find('thead th').addClass('myFilter');

//           var cnt=0;

//           var myExcelFilter=[];

//           $('.myFilter').each(function(e){

//             cnt++;

//             myExcelFilter.push(cnt);

//           });

//           // alert(cnt);

//           configFilter(this,myExcelFilter);

//           // make_sub_total();

//           // make_grand_total();

//           $('.set-column-visibility').each(function(e){

//             if($(this).data('status')=='hidden')

//             {

//                 let column = table.column($(this).data('col'));

//                 column.visible(false);

//             }

//           });

//       },

//       "dom": "<'row'<'col-sm-12 col-md-2 pr-0 mr-0'l><'col-sm-12 col-md-6 pl-0 ml-0 text-center'B><'col-sm-12 col-md-4'f>>" +

//                   "<'row'<'col-sm-12'tr>>" +

//                   "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-6'p>>",

// 			buttons: [

// 			        {

// 			            text: '<span class="fas fa-table" aria-hidden="true"></span> Manage Columns',

// 			            attr: {

// 			              class: 'btn btn-info btn-sm',

// 			              id   : 'btn-hide-show-dt-cols'

// 			            },

// 			            action: function ( e, dt, node, config ) {

			                

// 			            }

// 			        }

// 			    ]		

		

	     

//   });

	$('#btn-add').on('click',function(e){

	    if($('#country_id').val() != $('#phonecode_id').val()){

	        show_notification('warning','selected country not match country with code');

	        return false;

	    }

		let frm = '#addForm';

		let addForm =$(frm)[0];

		if(generate_required(frm)=='yes'){return false;}

		if(check_clength(frm)=='yes'){return false;}

		ajax_insert(addForm,'addVendors','','#dt');

		let newUrl = base_url.split('/').slice(0, -1).join('/');	

		$('#image_preview').attr('src',newUrl+'/admin/assets/all_images/car-logo-placeholder.png');

	});



	$('#edit-modal').on('show.bs.modal',function(e){

		let unique_id = e.relatedTarget.id;

		fill_edit_fields(unique_id,'#edit-modal','editvendors');

		

	});



	$('#btn-update').on('click',function(e){

	   var country_id = $('#e_country_id').val();

	    var phonecode_id = $('#e_phonecode_id').val();

	    if(country_id != phonecode_id){

	        show_notification('warning','selected country not match country with code');

	        return false;

	    }

		let frm = '#editForm';

		let editForm =$(frm)[0];

		if(generate_required(frm)=='yes'){return false;}

		ajax_update(editForm,'/updateVendors','#edit-modal','#dt');

	});



	$(document).on('click','#btn-delete',function(e){

	    e.preventDefault();

		var unique_id =$('#delete-id').val();

		let myFormSubmission = base_url+'/deleteVendors';

		ajax_delete(unique_id,myFormSubmission,'#dt');

	});







      $(document).on('click','#btn-hide-show-dt-cols',function(e){

          $('#mycars-cols-modal').modal('show');

      });



      $('#mycars-cols-modal').on('shown.bs.modal',function(e){

          $('.dt-swtch-show-hide-cols').each(function(e){

             let column_index = $(this).data('col');

             let yeh = $(this);

             $('.set-column-visibility').each(function(e){

               if($(this).data('status')=='hidden' && $(this).data('col')===column_index)

               {

                   yeh.bootstrapToggle('off');

               }

             });

          })

      });



      $(document).on('change','.dt-swtch-show-hide-cols',function(e){

          let column_index = $(this).attr('data-col');

          let column_status= 'hidden';

          if($(this).is(':checked'))

          {

            column_status = 'showing';

          }

          let column = table.column(column_index);

          column.visible(!column.visible());

          $.ajax({

            url:base_url+'members/set_my_cars_columns',

            type:'POST',

            data:{column_index:column_index,column_status:column_status},

            success:function(msg)

            {



            }

          });

      });


	$('.phoneCodeDropdown').select2({
		templateResult: function (data, container) {
			if (!data.id) {
				return data.text;
			}
			var iso = $(data.element).data('iso');
			var $option = $(
				'<span><i class="flag-icon flag-icon-' + iso.toLowerCase() + '"></i> ' + data.text + '</span>'
			);
			return $option;
		}
	});

	$('#country_id').on('change', function() 
	{

	  var selectedCountry = $(this).val();

	  $('#phonecode_id').val(selectedCountry).trigger('change.select2');
	  
	});

	$('#e_country_id').on('change', function() 
	{

	  var selectedCountry = $(this).val();

	  $('#e_phonecode_id').val(selectedCountry).trigger('change.select2');
	  
	});


});