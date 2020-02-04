$(function(){
	
	$('#nuevo-archivo-detalle').on('click',function(){
		$('#subida-detalle')[0].reset();
		
		$('#registra-archivo-detalle').modal({
			show:true,
			backdrop:'static'
		});
		
	$('#subida-detalle').submit(function(){
		
		var comprobar = $('#foto').val().length;
		if(comprobar>0){
		var formulario = $('#subida-detalle');
		var datos = formulario.serialize();
		var archivos = new FormData();	
		var url = '../php/documento_abono1.php';
		for (var i = 0; i < (formulario.find('input[type=file]').length); i++) { 
		 archivos.append((formulario.find('input[type="file"]:eq('+i+')').attr("name")),((formulario.find('input[type="file"]:eq('+i+')')[0]).files[0]));
		}
		$.ajax({
		url: url+'?'+datos,
		type: 'POST',
		contentType: false, 
		data: archivos,
		processData:false,
		beforeSend : function (){
		$('#cargando').show(300);	
		},
		success: function(data){
		$('#cargando').hide(300);
		location.reload();
		return false;
		}
		});
		return false;
		}else{
		alert('-- ADJUNTE DOCUMENTO--');
		return false;
		}
	});
	
});
});

function reg_contrato(){
	var cont = $('input:text[name=contrato]').val();
	var url = '../php/registrar_contrato_usu.php';
	$.ajax({
		type:'POST',
		url:url,
		data:'id='+localStorage.getItem('unmsm_id_pac')+'&contrato='+cont,
		success: function(){
			$.amaran({
			        'theme' :'awesome ok',
        			'content':{
            		title:'CONTRATO ACTUALIZADO CORRECTAMENTE!',
            		message:'',
            		info:'',
            		icon:'fa fa-check-square-o'
        },
        'position'  :'top right',
        'outEffect' :'slideBottom'
			    });
		localStorage.clear();
		},
		error: function(){
			$.amaran({
			        'theme' :'awesome error',
        			'content':{
            		title:'CONTRATO ACTUALIZADO CORRECTAMENTE!',
            		message:'',
            		info:'',
            		icon:'fa fa-check-square-o'
        },
        'position'  :'top right',
        'outEffect' :'slideBottom'
			    });
		}
	});
}

function eliminarUsuario(id){
	var url = '../php/elimina_paciente.php';
	var pregunta = confirm('¿Esta seguro de eliminar este Paciente?');
	if(pregunta==true){
		$.ajax({
		type:'POST',
		url:url,
		data:'id='+id,
		success: function(){
			var url = document.URL;
		location.href=url;
			return false;
		}
	});
	return false;
	}else{
		return false;
	}
}

function eliminarPaciente_diagnostico(id,h_c,m_h_c){
	if(h_c == m_h_c){
	var url = '../php/elimina_paciente_diagnostico.php';
	var pregunta = confirm('¿Esta seguro de eliminar este Paciente?');
	
	if(pregunta==true){
		$.ajax({
		type:'POST',
		url:url,
		data:'id='+id,
		success: function(){
			var url = document.URL;
		location.href=url;
			return false;
		}
	});
	return false;
	}else{
		return false;
	}	
	
	}else{
		alert("NO SE PUEDE ELIMINAR PORQUE NO ES LA ULTIMA HISTORIA CLINICA, DEBES MODIFICAR CON OTROS DATOS.");
	}
	
	
}

$(function(){
	
	$('#nuevo-archivo-detalle_abono2').on('click',function(){
		$('#subida-detalle_abono2')[0].reset();
		
		$('#registra-archivo-detalle_abono2').modal({
			show:true,
			backdrop:'static'
		});
		
	$('#subida-detalle_abono2').submit(function(){
		
		var comprobar = $('#foto2').val().length;
		if(comprobar>0){
		var formulario = $('#subida-detalle_abono2');
		var datos = formulario.serialize();
		var archivos = new FormData();	
		var url = '../php/documento_abono2.php';
		for (var i = 0; i < (formulario.find('input[type=file]').length); i++) { 
		 archivos.append((formulario.find('input[type="file"]:eq('+i+')').attr("name")),((formulario.find('input[type="file"]:eq('+i+')')[0]).files[0]));
		}
		$.ajax({
		url: url+'?'+datos,
		type: 'POST',
		contentType: false, 
		data: archivos,
		processData:false,
		beforeSend : function (){
		$('#cargando').show(300);	
		},
		success: function(data){
		$('#cargando').hide(300);
		location.reload();
		return false;
		}
		});
		return false;
		}else{
		alert('-- ADJUNTE DOCUMENTO--');
		return false;
		}
	});
	
});
});

$(function(){
	$('#guardar').on('click', function(){
		var url = document.URL;
		location.href=url;
	});
	
	$('#nuevo-seguimiento').on('click',function(){
		$('#seguimiento')[0].reset();
		$('#pro').val('Registro');
		$('#edi').hide();
		$('#reg').show();
		$('#registra-seguimiento').modal({
			show:true,
			backdrop:'static'
		});
	});
	

	
});

$(function(){
	$('#servicio').on('change', function(){
		var id = $('#servicio').val();
		var url = '../php/monto.php';
		$.ajax({
			type:'POST',
			url:url,
			data:'id='+id,
			success: function(data){
				$('#monto').empty();
				$('#monto').append(data);
				
			}
		});
		return false;
	});
	});

function agregaSeguimiento(){
	var url = '../php/agrega_producto.php';
	$.ajax({
		type:'POST',
		url:url,
		data:$('#seguimiento').serialize(),
		success: function(registro){
			if ($('#pro').val() == 'Registro'){
			$('#seguimiento')[0].reset();
			$('#mensaje').addClass('bien').html('Añadido con Exito').show(200).delay(2500).hide(200);
			$('#agrega-seguimiento').html(registro);
			return false;
			}else{
			$('#mensaje').addClass('bien').html('Modificado con Exito').show(200).delay(2500).hide(200);
			$('#agrega-seguimiento').html(registro);
			return false;
			}
		}
	});
	return false;
}

$(function(){
	$('#tipo_clinica').on('change', function(){
		var id = $('#tipo_clinica').val();
		var url = '../php/agrega_clinica.php';
		$.ajax({
			type:'POST',
			url:url,
			data:'id='+id,
			success: function(data){
				$('#n_clinica').empty();
				$('#n_clinica').append(data);
				
			}
		});
		return false;
	});
	});
	
$(function(){
	$('#modal_tipo_clinica').on('change', function(){
		var id = $('#modal_tipo_clinica').val();
		var url = '../php/agrega_clinica.php';
		$.ajax({
			type:'POST',
			url:url,
			data:'id='+id,
			success: function(data){
				$('#modal_n_clinica').empty();
				$('#modal_n_clinica').append(data);
				
			}
		});
		return false;
	});
	});

$(function(){
	$('#tipo_clinica_all').on('change', function(){
		var id = $('#tipo_clinica_all').val();
		var url = '../php/agrega_clinica_admision.php';
		$.ajax({
			type:'POST',
			url:url,
			data:'id='+id,
			success: function(data){
				$('#n_clinica_all').empty();
				$('#n_clinica_all').append(data);
				
			}
		});
		return false;
	});
	});

$(function(){
	$('#n_clinica').on('change', function(){
		var id = $('#n_clinica').val();
		var url = '../php/agrega_especialidad.php';
		$.ajax({
			type:'POST',
			url:url,
			data:'id='+id,
			success: function(data){
				$('#especialidad').empty();
				$('#especialidad').append(data);
				
			}
		});
		return false;
	});
	});

	
//PACIENTES//
function lista_paciente(valor,pagina){
	var pagina=Number(pagina);
	$.ajax({
		url:'../Controllers/CListar_pacientes.php',
		type:'POST',
		data:'valor='+valor+'&pagina='+pagina+'&boton=buscar'
	}).done(function(resp){
		var d=resp.split("*");
		//Imprimimos los registro en nuestra Table
		var valores = eval(d[0]);
		html="<table class='table table-hover' style='table-layout:fixed;font-size:15px' ><thead><tr class='active'><th width='100'><div align='center'>NOMBRE Y APELLIDO</div></th><th width='40'><div align='center'>DNI</div></th><th width='50'><div align='center'>SEXO</div></th><th width='60'><div align='center'>DISTRITO</div></th><th width='100'><div align='center'>DIRECCIÓN</div></th><th width='50'><div align='center'>CELULAR</div></th><th width='35'><div align='center'>HISTORIA</div></th><th width='30'><div align='center'>CONTRATO</div></th><th width='80'><div align='center'>CORREO</div></th><th width='40'><div align='center'>OPCIONES</div></th></tr></thead><tbody>";
		for(i=0;i<valores.length;i++){
			datos=valores[i][0]+"*"+valores[i][1]+"*"+valores[i][2]+"*"+valores[i][3]+"*"+valores[i][4]+"*"+valores[i][5]+"*"+valores[i][6]+"*"+valores[i][7]+"*"+valores[i][8]+"*"+valores[i][9];
			html+="<tr><td>"+valores[i][1]+"</td><td>"+valores[i][2]+"</td><td>"+valores[i][3]+"</td><td>"+valores[i][4]+"</td><td>"+valores[i][5]+"</td><td>"+valores[i][6]+"</td><td>"+valores[i][7]+"</td><td>"+valores[i][8]+"</td><td>"+valores[i][9]+"</td><td><a href='javascript:editarPaciente("+'"'+datos+'"'+");'><span title='Editar' class='glyphicon glyphicon-edit'></span></a>&nbsp;<a href='javascript:eliminarUsuario("+'"'+valores[i][0]+'"'+")'><span title='Eliminar' class='glyphicon glyphicon-remove-circle'></span></a></td></tr>";
		}
		html+="</tbody></table>"
		$("#lista").html(html);
		var totalreg= d[1];
		var nropaginador=Math.ceil(totalreg/40);
		var campobuscar=$("#buscar").val();
		//alert(nropaginador);
		paginar="<ul class='pagination'>";
		if(pagina>1)
		{
			paginar+="<li><a href='javascript:void(0)' onclick='lista_paciente("+'"'+campobuscar+'","'+1+'"'+")'>&laquo;</a></li>";
			paginar+="<li><a href='javascript:void(0)' onclick='lista_paciente("+'"'+campobuscar+'","'+(pagina-1)+'"'+")'>&lsaquo;</a></li>";

		}
		else
		{
			paginar+="<li class='disabled'><a href='javascript:void(0)'>&laquo;</a></li>";
			paginar+="<li class='disabled'><a href='javascript:void(0)'>&lsaquo;</a></li>";
		}
			limite = 10;
 			div = Math.ceil(limite / 2);
			pagInicio = (pagina > div) ? (pagina - div) : 1;
			if (nropaginador > div)
			{
				pagRestantes = nropaginador - pagina;
				pagFin = (pagRestantes > div) ? (pagina + div) :nropaginador;
			}
			else 
			{
				pagFin = nropaginador;
			}
			for(i=pagInicio;i<=pagFin;i++){
				if(i==pagina)
					paginar+="<li class='active'><a href='javascript:void(0)'>"+i+"</a></li>";
				else
					paginar+="<li><a href='javascript:void(0)' onclick='lista_paciente("+'"'+campobuscar+'","'+i+'"'+")'>"+i+"</a></li>";
			}
		
		

		if(pagina<nropaginador)
		{
			paginar+="<li><a href='javascript:void(0)' onclick='lista_paciente("+'"'+campobuscar+'","'+(pagina+1)+'"'+")'>&rsaquo;</a></li>";
			paginar+="<li><a href='javascript:void(0)' onclick='lista_paciente("+'"'+campobuscar+'","'+nropaginador+'"'+")'>&raquo;</a></li>";

		}
		else
		{
			paginar+="<li class='disabled'><a href='javascript:void(0)'>&rsaquo;</a></li>";
			paginar+="<li class='disabled'><a href='javascript:void(0)'>&raquo;</a></li>";
		}
		paginar+="</ul>";
		$("#paginador").html(paginar);
		
	});
}

//USUARIO

function listar_usuario(valor,pagina){
	var pagina=Number(pagina);
	$.ajax({
		url:'../Controllers/CListar_usuario.php',
		type:'POST',
		data:'valor='+valor+'&pagina='+pagina+'&boton=buscar'
	}).done(function(resp){
		var d=resp.split("*");
		//Imprimimos los registro en nuestra Table
		var valores = eval(d[0]);
		html="<table class='table table-hover' style='table-layout:fixed;font-size:15px' ><thead><tr class='active'><th width='140'><div align='center'>NOMBRE Y APELLIDO</div></th><th width='40'><div align='center'>USUARIO</div></th><th width='110'><div align='center'>CORREO</div></th><th width='60'><div align='center'>CELULAR</div></th><th width='60'><div align='center'>PERFIL</div></th><th width='40'><div align='center'>OPCIONES</div></th></tr></thead><tbody>";
		for(i=0;i<valores.length;i++){
			datos=valores[i][0]+"*"+valores[i][1]+"*"+valores[i][2]+"*"+valores[i][3]+"*"+valores[i][4]+"*"+valores[i][5];
			html+="<tr><td>"+valores[i][1]+"</td><td>"+valores[i][2]+"</td><td>"+valores[i][3]+"</td><td>"+valores[i][4]+"</td><td>"+valores[i][5]+"</td><td><a href='javascript:editarUsuario("+'"'+datos+'"'+");'><span title='Editar' class='glyphicon glyphicon-edit'></span></a>&nbsp;<a href='javascript:eliminarUsuario("+'"'+valores[i][0]+'"'+")'><span title='Eliminar' class='glyphicon glyphicon-remove-circle'></span></a></td></tr>";
		}
		html+="</tbody></table>"
		$("#lista").html(html);
		var totalreg= d[1];
		var nropaginador=Math.ceil(totalreg/40);
		var campobuscar=$("#buscar").val();
		//alert(nropaginador);
		paginar="<ul class='pagination'>";
		if(pagina>1)
		{
			paginar+="<li><a href='javascript:void(0)' onclick='listar_usuario("+'"'+campobuscar+'","'+1+'"'+")'>&laquo;</a></li>";
			paginar+="<li><a href='javascript:void(0)' onclick='listar_usuario("+'"'+campobuscar+'","'+(pagina-1)+'"'+")'>&lsaquo;</a></li>";

		}
		else
		{
			paginar+="<li class='disabled'><a href='javascript:void(0)'>&laquo;</a></li>";
			paginar+="<li class='disabled'><a href='javascript:void(0)'>&lsaquo;</a></li>";
		}
			limite = 10;
 			div = Math.ceil(limite / 2);
			pagInicio = (pagina > div) ? (pagina - div) : 1;
			if (nropaginador > div)
			{
				pagRestantes = nropaginador - pagina;
				pagFin = (pagRestantes > div) ? (pagina + div) :nropaginador;
			}
			else 
			{
				pagFin = nropaginador;
			}
			for(i=pagInicio;i<=pagFin;i++){
				if(i==pagina)
					paginar+="<li class='active'><a href='javascript:void(0)'>"+i+"</a></li>";
				else
					paginar+="<li><a href='javascript:void(0)' onclick='listar_usuario("+'"'+campobuscar+'","'+i+'"'+")'>"+i+"</a></li>";
			}
		
		

		if(pagina<nropaginador)
		{
			paginar+="<li><a href='javascript:void(0)' onclick='listar_usuario("+'"'+campobuscar+'","'+(pagina+1)+'"'+")'>&rsaquo;</a></li>";
			paginar+="<li><a href='javascript:void(0)' onclick='listar_usuario("+'"'+campobuscar+'","'+nropaginador+'"'+")'>&raquo;</a></li>";

		}
		else
		{
			paginar+="<li class='disabled'><a href='javascript:void(0)'>&rsaquo;</a></li>";
			paginar+="<li class='disabled'><a href='javascript:void(0)'>&raquo;</a></li>";
		}
		paginar+="</ul>";
		$("#paginador").html(paginar);
		
	});
}
//diagnostico

function lista_paciente_diagnostico(valor,pagina){
	var pagina=Number(pagina);
	var ult_h_c=$("#ult_h_c").val();
	$.ajax({
		url:'../Controllers/CListar_paciente_diagnostico.php',
		type:'POST',
		data:'valor='+valor+'&pagina='+pagina+'&boton=buscar'
	}).done(function(resp){
		var d=resp.split("*");
		//Imprimimos los registro en nuestra Table
		var valores = eval(d[0]);
		html="<table id='diag'><tr><td>N° BOLETA</td><td>HISTORIA</td><td>APELLIDOS Y NOMBRES</td><td>DNI</td><td>EDAD</td><td>FECHA REGISTRO</td><td>PRE</td><td>POS</td><td>OPERADOR</td><td>AÑO</td><td>OPCIONES</td></tr>";
		for(i=0;i<valores.length;i++){
			datos=valores[i][0]+"*"+valores[i][1]+"*"+valores[i][2]+"*"+valores[i][3]+"*"+valores[i][4]+"*"+valores[i][5]+"*"+valores[i][6]+"*"+valores[i][7]+"*"+valores[i][8]+"*"+valores[i][9]+"*"+valores[i][10];
			html+="<tr><td>"+valores[i][1]+"</td><td>"+valores[i][2]+"</td><td>"+valores[i][3]+"</td><td>"+valores[i][4]+"</td><td>"+valores[i][5]+"</td><td>"+valores[i][6]+"</td><td>"+valores[i][7]+"</td><td>"+valores[i][8]+"</td><td>"+valores[i][9]+"</td><td>"+valores[i][10]+"</td><td><a href='javascript:editarPaciente_Diagnostico("+'"'+datos+'"'+");'><span title='Editar' class='glyphicon glyphicon-edit'></span></a>&nbsp;<a href='javascript:eliminarPaciente_diagnostico("+'"'+valores[i][0]+'"'+","+'"'+valores[i][2]+'"'+","+'"'+ult_h_c+'"'+")'><span title='Eliminar' class='glyphicon glyphicon-remove-circle'></span></a></td></tr>";
		}
		html+="</tbody></table>"
		$("#lista").html(html);
		var totalreg= d[1];
		var nropaginador=Math.ceil(totalreg/40);
		var campobuscar=$("#buscar").val();
		//alert(nropaginador);
		paginar="<ul class='pagination'>";
		if(pagina>1)
		{
			paginar+="<li><a href='javascript:void(0)' onclick='lista_paciente_diagnostico("+'"'+campobuscar+'","'+1+'"'+")'>&laquo;</a></li>";
			paginar+="<li><a href='javascript:void(0)' onclick='lista_paciente_diagnostico("+'"'+campobuscar+'","'+(pagina-1)+'"'+")'>&lsaquo;</a></li>";

		}
		else
		{
			paginar+="<li class='disabled'><a href='javascript:void(0)'>&laquo;</a></li>";
			paginar+="<li class='disabled'><a href='javascript:void(0)'>&lsaquo;</a></li>";
		}
			limite = 10;
 			div = Math.ceil(limite / 2);
			pagInicio = (pagina > div) ? (pagina - div) : 1;
			if (nropaginador > div)
			{
				pagRestantes = nropaginador - pagina;
				pagFin = (pagRestantes > div) ? (pagina + div) :nropaginador;
			}
			else 
			{
				pagFin = nropaginador;
			}
			for(i=pagInicio;i<=pagFin;i++){
				if(i==pagina)
					paginar+="<li class='active'><a href='javascript:void(0)'>"+i+"</a></li>";
				else
					paginar+="<li><a href='javascript:void(0)' onclick='lista_paciente_diagnostico("+'"'+campobuscar+'","'+i+'"'+")'>"+i+"</a></li>";
			}
		
		

		if(pagina<nropaginador)
		{
			paginar+="<li><a href='javascript:void(0)' onclick='lista_paciente_diagnostico("+'"'+campobuscar+'","'+(pagina+1)+'"'+")'>&rsaquo;</a></li>";
			paginar+="<li><a href='javascript:void(0)' onclick='lista_paciente_diagnostico("+'"'+campobuscar+'","'+nropaginador+'"'+")'>&raquo;</a></li>";

		}
		else
		{
			paginar+="<li class='disabled'><a href='javascript:void(0)'>&rsaquo;</a></li>";
			paginar+="<li class='disabled'><a href='javascript:void(0)'>&raquo;</a></li>";
		}
		paginar+="</ul>";
		$("#paginador").html(paginar);
		
	});
}


function lista_paciente_archivo(valor,pagina){
	var pagina=Number(pagina);
	$.ajax({
		url:'../Controllers/CListar_paciente_archivo.php',
		type:'POST',
		data:'valor='+valor+'&pagina='+pagina+'&boton=buscar'
	}).done(function(resp){
		var d=resp.split("*");
		//Imprimimos los registro en nuestra Table
		var valores = eval(d[0]);
		html="<table class='table table-hover' style='table-layout:fixed;font-size:15px'><tr><td>APELLIDO Y NOMBRE</td><td>HISTORIA</td><td>CONTRATO</td><td>CONTRATO PASADO</td><td>CONTRATO ACTUALIZADO</td><td>FECHA HISTORIA</td><td>FECHA CONTRATO</td><td>FECHA ACTUALIZACION</td><td>OPERADOR</td><td>DNI OPERADOR</td><td>ALUMNO TRANSFERIDO</td><td>DNI TRANSFERIDO</td><td>OPCIONES</td></tr><tbody>";
		for(i=0;i<valores.length;i++){
			datos=valores[i][0]+"*"+valores[i][1]+"*"+valores[i][2]+"*"+valores[i][3]+"*"+valores[i][4]+"*"+valores[i][5]+"*"+valores[i][6]+"*"+valores[i][7]+"*"+valores[i][8]+"*"+valores[i][9]+"*"+valores[i][10]+"*"+valores[i][11]+"*"+valores[i][12];
			html+="<tr><td>"+valores[i][1]+"</td><td>"+valores[i][2]+"</td><td>"+valores[i][3]+"</td><td>"+valores[i][4]+"</td><td>"+valores[i][5]+"</td><td>"+valores[i][6]+"</td><td>"+valores[i][7]+"</td><td>"+valores[i][8]+"</td><td>"+valores[i][9]+"</td><td>"+valores[i][10]+"</td><td>"+valores[i][11]+"</td><td>"+valores[i][12]+"</td><td><a href='javascript:editarPaciente_Archivo("+'"'+datos+'"'+");'><span title='Editar' class='glyphicon glyphicon-edit'></span></a>&nbsp;<a href='javascript:eliminarPaciente_Archivo("+'"'+valores[i][0]+'"'+")'><span title='Eliminar' class='glyphicon glyphicon-remove-circle'></span></a></td></tr>";
		}
		html+="</tbody></table>"
		$("#lista").html(html);
		var totalreg= d[1];
		var nropaginador=Math.ceil(totalreg/40);
		var campobuscar=$("#buscar").val();
		//alert(nropaginador);
		paginar="<ul class='pagination'>";
		if(pagina>1)
		{
			paginar+="<li><a href='javascript:void(0)' onclick='lista_paciente_archivo("+'"'+campobuscar+'","'+1+'"'+")'>&laquo;</a></li>";
			paginar+="<li><a href='javascript:void(0)' onclick='lista_paciente_archivo("+'"'+campobuscar+'","'+(pagina-1)+'"'+")'>&lsaquo;</a></li>";

		}
		else
		{
			paginar+="<li class='disabled'><a href='javascript:void(0)'>&laquo;</a></li>";
			paginar+="<li class='disabled'><a href='javascript:void(0)'>&lsaquo;</a></li>";
		}
			limite = 10;
 			div = Math.ceil(limite / 2);
			pagInicio = (pagina > div) ? (pagina - div) : 1;
			if (nropaginador > div)
			{
				pagRestantes = nropaginador - pagina;
				pagFin = (pagRestantes > div) ? (pagina + div) :nropaginador;
			}
			else 
			{
				pagFin = nropaginador;
			}
			for(i=pagInicio;i<=pagFin;i++){
				if(i==pagina)
					paginar+="<li class='active'><a href='javascript:void(0)'>"+i+"</a></li>";
				else
					paginar+="<li><a href='javascript:void(0)' onclick='lista_paciente_archivo("+'"'+campobuscar+'","'+i+'"'+")'>"+i+"</a></li>";
			}
		
		

		if(pagina<nropaginador)
		{
			paginar+="<li><a href='javascript:void(0)' onclick='lista_paciente_archivo("+'"'+campobuscar+'","'+(pagina+1)+'"'+")'>&rsaquo;</a></li>";
			paginar+="<li><a href='javascript:void(0)' onclick='lista_paciente_archivo("+'"'+campobuscar+'","'+nropaginador+'"'+")'>&raquo;</a></li>";

		}
		else
		{
			paginar+="<li class='disabled'><a href='javascript:void(0)'>&rsaquo;</a></li>";
			paginar+="<li class='disabled'><a href='javascript:void(0)'>&raquo;</a></li>";
		}
		paginar+="</ul>";
		$("#paginador").html(paginar);
		
	});
}
//operador
function lista_operador(valor,pagina){
	var pagina=Number(pagina);
	$.ajax({
		url:'../Controllers/CListar_Operador.php',
		type:'POST',
		data:'valor='+valor+'&pagina='+pagina+'&boton=buscar'
	}).done(function(resp){
		var d=resp.split("*");
		var item= 0;
		//Imprimimos los registro en nuestra Table
		var valores = eval(d[0]);
		html="<div class='table-responsive'><table class='table'><thead><tr><th>N°</th><th>FECHA CITA</th><th>NOMBRE Y APELLIDO</th><th>HISTORIA CLINICA</th><th>CONTRATO</th><th>DNI</th><th>TIPO CLINICA</th><th>NRO CLINICA</th><th>ESPECIALIDAD</th><th>OPERADOR</th><th>DOCENTE CLINICA</th></tr></thead><tbody>";
		for(i=0;i<valores.length;i++){
			item = item + 1;
			datos=valores[i][0]+"*"+valores[i][1]+"*"+valores[i][2]+"*"+valores[i][3]+"*"+valores[i][4]+"*"+valores[i][5]+"*"+valores[i][6]+"*"+valores[i][7]+"*"+valores[i][8]+"*"+valores[i][9]+"*"+valores[i][10];
			html+="<tr><td>"+ item +"</td><td><a href='det_cita_ope.php?recordID="+valores[i][0]+"'>"+valores[i][1]+"</a></td><td>"+valores[i][2]+"</td><td>"+valores[i][3]+"</td><td>"+valores[i][4]+"</td><td>"+valores[i][5]+"</td><td>"+valores[i][6]+"</td><td>"+valores[i][7]+"</td><td>"+valores[i][8]+"</td><td>"+valores[i][9]+"</td><td>"+valores[i][10]+"</td></tr>";
		}
		html+="</tbody></table></div>"
		$("#lista").html(html);
		var totalreg= d[1];
		var nropaginador=Math.ceil(totalreg/40);
		var campobuscar=$("#buscar").val();
		//alert(nropaginador);
		paginar="<ul class='pagination'>";
		if(pagina>1)
		{
			paginar+="<li><a href='javascript:void(0)' onclick='lista_operador("+'"'+campobuscar+'","'+1+'"'+")'>&laquo;</a></li>";
			paginar+="<li><a href='javascript:void(0)' onclick='lista_operador("+'"'+campobuscar+'","'+(pagina-1)+'"'+")'>&lsaquo;</a></li>";

		}
		else
		{
			paginar+="<li class='disabled'><a href='javascript:void(0)'>&laquo;</a></li>";
			paginar+="<li class='disabled'><a href='javascript:void(0)'>&lsaquo;</a></li>";
		}
			limite = 10;
 			div = Math.ceil(limite / 2);
			pagInicio = (pagina > div) ? (pagina - div) : 1;
			if (nropaginador > div)
			{
				pagRestantes = nropaginador - pagina;
				pagFin = (pagRestantes > div) ? (pagina + div) :nropaginador;
			}
			else 
			{
				pagFin = nropaginador;
			}
			for(i=pagInicio;i<=pagFin;i++){
				if(i==pagina)
					paginar+="<li class='active'><a href='javascript:void(0)'>"+i+"</a></li>";
				else
					paginar+="<li><a href='javascript:void(0)' onclick='lista_operador("+'"'+campobuscar+'","'+i+'"'+")'>"+i+"</a></li>";
			}
		
		

		if(pagina<nropaginador)
		{
			paginar+="<li><a href='javascript:void(0)' onclick='lista_operador("+'"'+campobuscar+'","'+(pagina+1)+'"'+")'>&rsaquo;</a></li>";
			paginar+="<li><a href='javascript:void(0)' onclick='lista_operador("+'"'+campobuscar+'","'+nropaginador+'"'+")'>&raquo;</a></li>";

		}
		else
		{
			paginar+="<li class='disabled'><a href='javascript:void(0)'>&rsaquo;</a></li>";
			paginar+="<li class='disabled'><a href='javascript:void(0)'>&raquo;</a></li>";
		}
		paginar+="</ul>";
		$("#paginador").html(paginar);
		
	});
}
//fin
//FIN//
$(function(){
	$('#guardar').on('click', function(){
		var url = document.URL;
		location.href=url;
	});
	
	$('#nuevo-producto').on('click',function(){
		$('#formulario')[0].reset();
		$('#pro').val('Registro');
		$('#edi').hide();
		$('#reg').show();
		$('#activo').hide();
		$('#eti').hide();
		$('#registra-producto').modal({
			show:true,
			backdrop:'static'
		});
	});
	
});

function editarPaciente(id){
	$('#formulario')[0].reset();
	var url = '../php/edita_paciente.php';
		$.ajax({
		type:'POST',
		url:url,
		data:'id='+id,
		success: function(valores){
				var datos = eval(valores);
				$('#reg').hide();
				$('#edi').show();
				$('#id_paciente').val(datos[0]);
				$('#nombre_apellido').val(datos[1]);
				$('#dni').val(datos[2]);
				$('#sexo').val(datos[3]);
				$('#fecha_nacimiento').val(datos[4]);
				$('#direccion').val(datos[5]);
				$('#distrito').val(datos[6]);
				$('#estado_civil').val(datos[7]);
				$('#h_clinica').val(datos[8]);
				$('#contrato').val(datos[9]);
				$('#correo').val(datos[10]);
				$('#celular').val(datos[11]);
				$('#registra-producto').modal({
					show:true,
					backdrop:'static'
				});
			return false;
		}
	});
	return false;
}

function editarPaciente_Archivo(id){
	$('#formulario_act')[0].reset();
	var url = '../php/edita_paciente_archivo.php';
		$.ajax({
		type:'POST',
		url:url,
		data:'id='+id,
		success: function(valores){
				var datos = eval(valores);
				$('#reg').hide();
				$('#edi').show();
				$('#id_paciente').val(datos[0]);
				$('#nombre_apellido').val(datos[1]);
				$('#dni').val(datos[2]);
				$('#sexo').val(datos[3]);
				$('#fecha_nacimiento').val(datos[4]);
				$('#direccion').val(datos[5]);
				$('#distrito').val(datos[6]);
				$('#estado_civil').val(datos[7]);
				$('#h_clinica').val(datos[8]);
				$('#contrato').val(datos[9]);
				$('#correo').val(datos[10]);
				$('#celular').val(datos[11]);
				$('#date_h_clinica').val(datos[12]);
				$('#date_contrato').val(datos[13]);
				$('#ocupacion').val(datos[14]);
				$('#operador').val(datos[15]);
				$('#dni_operador').val(datos[16]);
				$('#grado_paciente').val(datos[17]);
				$('#grupo_sanguineo').val(datos[18]);
				$('#anio_alumno').val(datos[19]);
				$('#alum_tranferido').val(datos[20]);
				$('#anio_estudio').val(datos[21]);
				$('#dni_transferido').val(datos[22]);
				$('#contrato_pass').val(datos[23]);
				$('#contrato_new').val(datos[24]);
				$('#date_update').val(datos[25]);
				$('#cod_archivo').val(datos[26]);
				$('#actualizar_registra-producto').modal({
					show:true,
					backdrop:'static'
				});
			return false;
		}
	});
	return false;
}

function editarPaciente_Diagnostico(id){
	$('#formulario_act')[0].reset();
	var url = '../php/edita_paciente_diagnostico.php';
		$.ajax({
		type:'POST',
		url:url,
		data:'id='+id,
		success: function(valores){
				var datos = eval(valores);
				$('#reg').hide();
				$('#edi').show();
				$('#id_diagnostico').val(datos[0]);
				$('#fecha_registro').val(datos[1]);
				$('#n_boleta').val(datos[2]);
				$('#historia_clinica').val(datos[3]);
				$('#apellido_nombre').val(datos[4]);
				$('#dni').val(datos[5]);
				$('#edad').val(datos[6]);
				$('#pre').val(datos[7]);
				$('#pos').val(datos[8]);
				$('#operador').val(datos[9]);
				$('#anio').val(datos[10]);
				$('#cod_interno').val(datos[11]);
				$('#actualizar_registra-producto').modal({
					show:true,
					backdrop:'static'
				});
			return false;
		}
	});
	return false;
}

function editarUsuario(id){
	$('#formulario')[0].reset();
	var url = '../php/edita_usuario.php';
		$.ajax({
		type:'POST',
		url:url,
		data:'id='+id,
		success: function(valores){
				var datos = eval(valores);
				$('#reg').hide();
				$('#edi').show();
				$('#id_usuario').val(datos[0]);
				$('#usuario').val(datos[1]);
				$('#clave').val(datos[2]);
				$('#nombre_apellido').val(datos[3]);
				$('#correo').val(datos[4]);
				$('#celular').val(datos[5]);
				$('#id_perfil').val(datos[6]);
				$('#registra-producto').modal({
					show:true,
					backdrop:'static'
				});
			return false;
		}
	});
	return false;
}

$(document).ready(function() {
	inicializarEventos();
});

function inicializarEventos() {
	$('.form_date').datetimepicker({
        language:  'es',
        todayBtn:  1,
		autoclose: 1, 
		todayHighlight: 1,
		minView: 0,
		forceParse: 1
    });
}
