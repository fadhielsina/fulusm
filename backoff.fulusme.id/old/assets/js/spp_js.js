$(document).ready(function(){

});

function loadSPP(id,Ket=""){
	$.getJSON(server_url+"/Procurement/loadDataSPP/"+id,function(result){
		$("#supplierName").val(result.supplierName);
		$("#supplierBankname").val(result.supplierBankname);
		$("#supplierBankid").val(result.supplierBankid);
		$("#supplierNPWP").val(result.supplierNPWP); 
		$("#id_procurements").val(id);
		$("#uraian_spp").val(Ket);
		$("#frm_add_spp").show("slow");
        $("html, body").animate({
            scrollTop: 0
        }, 1000);
	})
	
	
        
	return false;
}
function loadSPM(id){
	//$("#id_procurements").val(id);
	//$("#frm_add_spp").show("slow");
	return false;
} 