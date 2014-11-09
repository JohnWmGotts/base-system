//var application_path1='http://demo.ncryptedprojects.com/nct_crowdfunding_clone/';
var application_path1='http://CrowdedRocket.com/';
// Delete Confirm Function
function delete_record() {
	if(confirm("Are you sure you want to delete this Record ?")) {
		return true;
	} else {
		return false;
	}
}
// Per page form submit function
function perpage(form) {
	form.submit();
}
