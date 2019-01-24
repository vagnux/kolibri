 var settings = {
        cpfMask: "###.###.###-##",
        cnpjMask: "##.###.###/####-##",
        cepMask: "#####-###",
        foneMask: "(##)####-####",
        celMask: "(##)#####-####",
        horaMask: "##:##",
        dataMask: "##/##/####",
        numMask: ""
    };
 
function formValide(form) {
	var formStatusField = true;
	var msg = '';
	$('#' + form)
			.find("input[type='text']")
			.each(
					function() {

						if ($(this).hasClass("html-form-cpf")) {
							$(this)
									.attr("size", settings["cpfMask"].length)
									.attr("maxlength",
											settings["cpfMask"].length)
									.keypress(
											function(event) {
												return mascara($(this).context,
														settings["cpfMask"],
														event)
											})
									.blur(
											function() {
												if (!verificaCPF($(this).val())
														&& $(this).val().length > 0) {
													$(this).val("");
													alert("CPF invalido");
												}
											});
							;
						} else if ($(this).hasClass("html-form-cnpj")) {
							$(this)
									.attr("size", settings["cnpjMask"].length)
									.attr("maxlength",
											settings["cnpjMask"].length)
									.keypress(
											function(event) {
												return mascara($(this).context,
														settings["cnpjMask"],
														event)
											})
									.blur(
											function() {
												if (!validaCnpj($(this).val())
														&& $(this).val().length > 0) {
													$(this).val("");
													alert("CNPJ invalido");
												}
											});
							;
						} else if ($(this).hasClass("html-form-cep")) {
							$(this)
									.attr("size", settings["cepMask"].length)
									.attr("maxlength",
											settings["cepMask"].length)
									.keypress(
											function(event) {
												return mascara($(this).context,
														settings["cepMask"],
														event)
											})
									.blur(
											function() {
												if (($(this).val().length != 9 || $(
														this).val()
														.substr(5, 1) != "-")
														&& $(this).val().length > 0) {
													$(this).val("");
													alert("CEP invalido");
												}
											});
						} 
					});


	$('#' + form)
			.find(
					"input[type='text'], input[type='date'], input[type='time'], input[type='password'],input[type='hidden'], select")
			.each(
					function() {

						if ($(this).hasClass("html-form-obrigatorio")
								&& $(this).val() == "") {
							formStatusField = false;
							msg += $("label[for='" + $(this).attr("id") + "']")
									.text()
									+ " deve ser preenchido.\n";
						}
						if ($(this).hasClass("passwordNameVerify")) {
							var fieldName = $('#passwordFieldName').val();

							if ($("[name='" + fieldName + "A']").val() != $(
									"[name='" + fieldName + "B']").val()) {
								msg += "Campos de Senha precisam ser iguais\n";
							}
						}

					});

	// Verifica se campos do tipo textarea obrigatÃ³rios
	// nÃ£o foram preenchidos devidamente
	$('#' + form).find("textarea").each(
			function() {
				var textfield = $.trim($(this).val());
				if ($(this).hasClass("html-form-obrigatorio")
						&& textfield.length < 15) {
					formStatusField = false;
					msg += $("label[for='" + $(this).attr("id") + "']").text()
							+ " deve ser preenchido corretamente.\n";
				}
			});

	// Inicializa o array de grupos de radios e checkbox com
	// false, cada indice corresponde ao nome de um grupo
	$('#' + form)
			.find(
					"input[type='checkbox'].html-form-obrigatorio, input[type='radio'].html-form-obrigatorio")
			.each(function() {
				radioCheck[$(this).attr("grupo")] = false;
			});

	

	// alert (" ivestiga " + formStatusField );
	// alert("denovo " + formStatusField);
	if (formStatusField) {
		
		return true;
	}
	alert(msg)
	return false;

}

function mascara(src, mascara, event) {
	var campo = src.value.length;
	var texto = mascara.substring(campo);
	var charCode = src.keyCode
	var keyCode = event.keyCode ? event.keyCode : event.which ? event.which
			: event.charCode;

	// Diferente de backspace, tab, delete e setas
	if (keyCode != 8 && keyCode != 9 && keyCode != 46
			&& (keyCode < 37 || keyCode > 40)) {
		// Somente os nÃºmeros e teclado numÃ©rico
		if ((keyCode > 47 && keyCode < 58) || (keyCode > 95 && keyCode < 106)) {
			if (texto.substring(0, 1) != '#') {
				src.value += texto.substring(0, 1);
			}
		} else {
			return false;
		}
	}
}

function verificaCPF(CPF) {
	// Elimina os pontos, traÃ§os e barras
	CPF = CPF.replace(".", "").replace(".", "").replace("-", "").replace("/",
			"");

	// Verifica se o campo estÃ¡ no formato correto
	if (CPF.length < 11 || CPF == "11111111111" || CPF == "22222222222"
			|| CPF == "33333333333" || CPF == "44444444444"
			|| CPF == "55555555555" || CPF == "66666666666"
			|| CPF == "77777777777" || CPF == "88888888888"
			|| CPF == "99999999999" || CPF == "00000000000") {
		// alert('CPF invÃ¡lido');
		return false;
	}

	// Aqui comeÃ§a a checagem do CPF
	var POSICAO, I, SOMA, DV, DV_INFORMADO;
	var DIGITO = new Array(10);
	DV_INFORMADO = CPF.substr(9, 2); // Retira os dois Ãºltimos dÃ­gitos do
	// nÃºmero informado

	// Desemembra o nÃºmero do CPF na array DIGITO
	for (I = 0; I <= 8; I++) {
		DIGITO[I] = CPF.substr(I, 1);
	}

	// Calcula o valor do 10Âº dÃ­gito da verificaÃ§Ã£o
	POSICAO = 10;
	SOMA = 0;
	for (I = 0; I <= 8; I++) {
		SOMA = SOMA + DIGITO[I] * POSICAO;
		POSICAO = POSICAO - 1;
	}
	DIGITO[9] = SOMA % 11;
	if (DIGITO[9] < 2) {
		DIGITO[9] = 0;
	} else {
		DIGITO[9] = 11 - DIGITO[9];
	}

	// Calcula o valor do 11Âº dÃ­gito da verificaÃ§Ã£o
	POSICAO = 11;
	SOMA = 0;
	for (I = 0; I <= 9; I++) {
		SOMA = SOMA + DIGITO[I] * POSICAO;
		POSICAO = POSICAO - 1;
	}
	DIGITO[10] = SOMA % 11;
	if (DIGITO[10] < 2) {
		DIGITO[10] = 0;
	} else {
		DIGITO[10] = 11 - DIGITO[10];
	}

	// Verifica se os valores dos dÃ­gitos verificadores conferem
	DV = DIGITO[9] * 10 + DIGITO[10];

	if (DV != DV_INFORMADO) {
		return false;
	} else {
		return true;
	}
}

function validaCnpj(str) {
	str = str.replace('.', '');
	str = str.replace('.', '');
	str = str.replace('.', '');
	str = str.replace('-', '');
	str = str.replace('/', '');
	cnpj = str;
	var numeros, digitos, soma, i, resultado, pos, tamanho, digitos_iguais;
	digitos_iguais = 1;
	if (cnpj.length < 14 && cnpj.length < 15)
		return false;
	for (i = 0; i < cnpj.length - 1; i++)
		if (cnpj.charAt(i) != cnpj.charAt(i + 1)) {
			digitos_iguais = 0;
			break;
		}
	if (!digitos_iguais) {
		tamanho = cnpj.length - 2
		numeros = cnpj.substring(0, tamanho);
		digitos = cnpj.substring(tamanho);
		soma = 0;
		pos = tamanho - 7;
		for (i = tamanho; i >= 1; i--) {
			soma += numeros.charAt(tamanho - i) * pos--;
			if (pos < 2)
				pos = 9;
		}
		resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
		if (resultado != digitos.charAt(0))
			return false;
		tamanho = tamanho + 1;
		numeros = cnpj.substring(0, tamanho);
		soma = 0;
		pos = tamanho - 7;
		for (i = tamanho; i >= 1; i--) {
			soma += numeros.charAt(tamanho - i) * pos--;
			if (pos < 2)
				pos = 9;
		}
		resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
		if (resultado != digitos.charAt(1))
			return false;
		return true;
	} else
		return false;
}