<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Validation - Counter</title>
@extends('layout.master')

@section("content")
<?php
// makeing parent and child relationship
/*$allgroup = array();
$i = 0;
foreach ($reportsname as $reportDetails) {
    $allgroup[$parentInfo[$reportDetails->parent_id]][$i]['id'] = $reportDetails->id;
    $allgroup[$parentInfo[$reportDetails->parent_id]][$i]['report_name'] = $reportDetails->report_name;
    $allgroup[$parentInfo[$reportDetails->parent_id]][$i]['report_code'] = $reportDetails->report_code;
    $i ++;
}*/
?>
    <!--========================login form start here======================================-->

<div class="main-content">
	@if (Session::has('error'))
	<div class="alert alert-success" style="color: red">{{
		Session::get('error') }}</div>
	@endif
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-lg-12 col-md-12">
			<ul class="nav nav-tabs ulTabs">
				<li class="active"><a data-toggle="tab" href="#file1">File Validate
				</a></li>
				<li><a data-toggle="tab" href="#menu1">SUSHI Validate</a></li>
			</ul>
			<div class="tab-content">
				<div id="file1" class="tab-pane fade in active">
					<div class="col-md-6">
						@if (Session::has('emailMsg'))
						<div class="alert alert-success">{{ Session::get('emailMsg') }}</div>
						@endif
						<form name="file_valid" method="post" class="file-uploader"
							action="fileValidate" enctype="multipart/form-data">
							<input type="hidden" name="_token"
								value="<?php echo csrf_token() ?>">
							<div class="file-uploader__message-area">
								<p>Upload File Here</p>
							</div>


							<div class="file-chooser">
								<input type="file" id="file" name="import_file">
							</div>
							<div id="pop1"></div>
							<input class="file-uploader__submit-button" type="submit"
								value="Validate" onclick="return check();">
							<div id="pop1"></div>


						</form>
					</div>
					<div class="col-md-6">
						<div class="widget stacked widget-table action-table">
							<div class="widget-header">
								<i class="fa fa-tasks" aria-hidden="true"></i>
								<h3>Old Downloads</h3>
							</div>
							<!-- /widget-header -->
							<div class="widget-content">
								<table class="table table-striped table-bordered">
									<thead>
										<tr>
											<th>File Type</th>
											<th>File Name</th>
											<th class="td-actions">Download</th>
										</tr>
									</thead>
									<tbody>
										<?php
        
        if (isset($file_detail)) {
            
            foreach ($file_detail as $filedetails) {
                ?>
        										<tr>
											<td><?php echo $filedetails->file_type;?></td>
											<td><?php echo $filedetails->filename;?></td>
											<td class="td-actions"><a
												href="download/{{$filedetails->id}}/{{$filedetails->filename}}"><i
													class="fa fa-download" aria-hidden="true"></i></a></td>
										</tr>
										<?php
            }
        }
        ?>
									</tbody>
								</table>
							</div>
							<!-- /widget-content -->
						</div>
						<!-- /widget -->
					</div>
					<div class="clearfix"></div>
				</div>
				<div id="menu1" class="tab-pane fade">
					<div class="col-xs-12 col-sm-12 col-md-12">
						<form name="sushi_validation" method="post" class="file-uploader1"
							action="sushiValidate" enctype="multipart/form-data">
							<fieldset>
								<h3>Requestor</h3>
								<hr class="colorgraph">

								<div class="form-group">
									<input value="{{ old('Requestorurl') }}" type="text"
										name="Requestorurl" id="Requestorurl"
										class="form-control input-lg" placeholder="COUNTER_SUSHI URL*"> <span
										style="color: #ff0000">{{
										$errors->welcome->first('Requestorurl') }}</span>
								</div>
								<div class="form-group col-md-6 noPaddingXS noLeftPadd">
									<input value="{{ old('CustomerId') }}" type="text"
										name="CustomerId" id="CustomerId"
										class="form-control input-lg" placeholder="Customer ID*"> <span
										style="color: #ff0000">{{
										$errors->welcome->first('CustomerId') }}</span>
								</div>
								<div class="form-group col-md-6 noRightPadd noPaddingXS">
								
								<select class="form-control input-lg">
                                 <option value="">APIKey</option>
                                    <option value="">Requestor ID</option>
                                     
								</select>
								</div>
								
								<div class="form-group">
									<input value="{{ old('APIkey') }}" type="text" name="APIkey"
										id="name" class="form-control input-lg"
										placeholder="Value*"> <span style="color: #ff0000">{{
										$errors->welcome->first('APIkey')}}</span>
								</div>
								</fieldset>
								<fieldset>
								<h3>Report Definition</h3>
								<hr class="colorgraph">
								<div class="form-group col-md-6 noPaddingXS noLeftPadd">
									<select name="ReportName" class="form-control input-lg">
                                    <?php
                                      if(isset($reportsname)){
                                        foreach($reportsname as $filedetails){
                                        ?>
                                        <option value="<?php echo strtolower($filedetails['report_code']); ?>"><?php echo $filedetails['report_name']." (".$filedetails['report_code'].")" ?></option>
                                        <?php
                                        }
                                      }
                                     
                                    
                                    ?>
                                   
                                    
                                <span style="color: #ff0000">{{
											$errors->welcome->first('ReportName') }}</span>
									</select>
								</div>
								<div class="form-group col-md-6 noPaddingXS noRightPadd">
									<input value="{{ old('Release') }}" maxlength="1" type="text"
										name="Release" id="Release" class="form-control input-lg"
										placeholder="Release Number*"> <span style="color: #ff0000">{{
										$errors->welcome->first('Release') }}</span>
								</div>
								<div class="form-group col-md-3 noPaddingXS noLeftPadd"
									id="sandbox-container">
									<input value="{{ old('month') }}" type="text" name="month"
										id="month" class="date-picker form-control input-lg"
										input-group placeholder="Select Month*"> <span
										style="color: #ff0000">{{ $errors->welcome->first('month') }}</span>
								</div>
								<div class="form-group col-md-3 noPaddingXS noLeftPadd"
									id="sandbox-container">
									<input value="{{ old('endmonth') }}" type="text"
										name="endmonth" id="month"
										class="date-picker form-control input-lg" input-group
										placeholder="Select Another Month*"> <span
										style="color: #ff0000">{{ $errors->welcome->first('endmonth')
										}}</span>
								</div>
								
                                </div>
								<div class="row">
									<div class="col-xs-6 col-sm-4 col-md-3">
										<input class="btn btn-lg btn-primary btn-block" type="submit"
											value="Validate" />
									</div>
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
								</div>
								<hr class="colorgraph">
							</fieldset>
						</form>
					</div>
					
					<div class="clearfix"></div>
				</div>

			</div>

		</div>

	</div>

</div>

@endsection
<!--========================login form END here======================================-->



@section("additionaljs")
<script>
	//jQuery plugin
(function( $ ) {
   
   $.fn.uploader = function( options ) {
     var settings = $.extend({
       MessageAreaText: "No files selected.",
       MessageAreaTextWithFiles: "File List:",
       DefaultErrorMessage: "Unable to open this file.",
       BadTypeErrorMessage: "We cannot accept this file type at this time.",
       acceptedFileTypes: ['pdf', 'jpg', 'gif', 'jpeg', 'bmp', 'tif', 'tiff', 'png', 'xps', 'doc', 'docx',
        'fax', 'wmp', 'ico', 'txt', 'cs', 'rtf', 'xls', 'xlsx', 'json']
     }, options );
  
     var uploadId = 1;
     //update the messaging 
      $('.file-uploader__message-area p').text(options.MessageAreaText || settings.MessageAreaText);
     
     //create and add the file list and the hidden input list
     var fileList = $('<ul class="file-list"></ul>');
     var hiddenInputs = $('<div class="hidden-inputs hidden"></div>');
     $('.file-uploader__message-area').after(fileList);
     $('.file-list').after(hiddenInputs);
     
    //when choosing a file, add the name to the list and copy the file input into the hidden inputs
     $('.file-chooser__input').on('change', function(){
        var file = $('.file-chooser__input').val();
        var fileName = (file.match(/([^\\\/]+)$/)[0]);

       //clear any error condition
       $('.file-chooser').removeClass('error');
       $('.error-message').remove();
       
       //validate the file
       var check = checkFile(fileName);
       if(check === "valid") {
         
         // move the 'real' one to hidden list 
         $('.hidden-inputs').append($('.file-chooser__input')); 
       
         //insert a clone after the hiddens (copy the event handlers too)
         $('.file-chooser').append($('.file-chooser__input').clone({ withDataAndEvents: true})); 
       
         //add the name and a remove button to the file-list
         $('.file-list').append('<li style="display: none;"><span class="file-list__name">' + fileName + '</span><button class="removal-button" data-uploadid="'+ uploadId +'"></button></li>');
         $('.file-list').find("li:last").show(800);
        
         //removal button handler
         $('.removal-button').on('click', function(e){
           e.preventDefault();
         
           //remove the corresponding hidden input
           $('.hidden-inputs input[data-uploadid="'+ $(this).data('uploadid') +'"]').remove(); 
         
           //remove the name from file-list that corresponds to the button clicked
           $(this).parent().hide("puff").delay(10).queue(function(){$(this).remove();});
           
           //if the list is now empty, change the text back 
           if($('.file-list li').length === 0) {
             $('.file-uploader__message-area').text(options.MessageAreaText || settings.MessageAreaText);
           }
         });
       
         //so the event handler works on the new "real" one
         $('.hidden-inputs .file-chooser__input').removeClass('file-chooser__input').attr('data-uploadId', uploadId); 
       
         //update the message area
         $('.file-uploader__message-area').text(options.MessageAreaTextWithFiles || settings.MessageAreaTextWithFiles);
         
         uploadId++;
         
       } else {
         //indicate that the file is not ok
         $('.file-chooser').addClass("error");
         var errorText = options.DefaultErrorMessage || settings.DefaultErrorMessage;
         
         if(check === "badFileName") {
           errorText = options.BadTypeErrorMessage || settings.BadTypeErrorMessage;
         }
         
         $('.file-chooser__input').after('<p class="error-message">'+ errorText +'</p>');
       }
     });
     
     var checkFile = function(fileName) {
       var accepted          = "invalid",
           acceptedFileTypes = this.acceptedFileTypes || settings.acceptedFileTypes,
           regex;

       for ( var i = 0; i < acceptedFileTypes.length; i++ ) {
         regex = new RegExp("\\." + acceptedFileTypes[i] + "$", "i");

         if ( regex.test(fileName) ) {
           accepted = "valid";
           break;
         } else {
           accepted = "badFileName";
         }
       }

       return accepted;
    };
  }; 
}( jQuery ));

/////init 

$(document).ready(function(){
  $('.fileUploader').uploader({
    MessageAreaText: "Upload File Here"
  });
 
});
  /*$('#sandbox-container .input-daterange').datepicker({
 	 changeMonth: true,
        changeYear: true,
      showButtonPanel: true,
        dateFormat: 'MM yy',
       onClose: function(dateText, inst) { 
            $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
        }    
    });  */ 
 $(function() {
  $('.date-picker').datepicker( {
    format: "yyyy-mm-dd",
     //viewMode: "months", 
     //minViewMode: "months"
    });
 });
</script>

@if(count($errors->welcome)>0)
<script>$(".ulTabs a[href='#menu1']").tab("show");</script>
@endif @if (Session::has('error'))
<script>$(".ulTabs a[href='#menu1']").tab("show");</script>
@endif 
@endsection

<script>
 function check()
{
 var aa = $("#file").val();
 
 var ext = aa.split('.').pop();
 //alert(ext);
 if(!((ext == 'tsv') || (ext == 'csv') || (ext == 'xlsx') || (ext == 'xls') || (ext == 'json')))
 {
  $("#pop1").html("<span style='color:#ff0000'>The File should be xls,xlsx,csv,tsv or json extensions</span>");
  return false;
 }
 
 
}
</script>

</head>
</html>

<!---=======================javascripts comes in bottom============================-->

