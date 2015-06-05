<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used by
	| the validator class. Some of these rules have multiple versions such
	| such as the size rules. Feel free to tweak each of these messages.
	|
	*/

	"accepted"         => "El campo :attribute debe ser aceptado.",
	"active_url"       => "El campo :attribute no es una URL valida.",
	"after"            => "El campo :attribute tiene que ser una fecha posterior a :date.",
	"alpha"            => "El campo :attribute solo puede contener letras.",
	"alpha_dash"       => "El campo :attribute solo puede contener letras, numeros y guiones.",
	"alpha_num"        => "El campo :attribute solo puede contener letras y numeros.",
	"array"            => "El campo :attribute tiene que ser un arreglo.",
	"before"           => "El campo :attribute tiene que ser una fecha anterior a :date.",
	"between"          => array(
		"numeric" => "El campo :attribute tiene que estar entre :min y :max.",
		"file"    => "El campo :attribute tiene que tener entre :min y :max kilobytes.",
		"string"  => "El campo :attribute tiene que tener entre :min y :max caracteres.",
		"array"   => "El campo :attribute tiene que tener entre :min y :max elementos.",
	),
	"confirmed"        => "El campo :attribute la confirmacion no coincide.",
	"date"             => "El campo :attribute no es una fecha valida.",
	"date_format"      => "El campo :attribute no cumple con el formato :format.",
	"different"        => "El campo :attribute y :other tienen que ser diferentes.",
	"digits"           => "El campo :attribute tiene que tener :digits digitos.",
	"digits_between"   => "El campo :attribute tiene que tener entre :min y :max digitos.",
	"email"            => "El campo :attribute no tiene un formato valido.",
	"exists"           => "El campo :attribute seleccionado es invalido.",
	"image"            => "El campo :attribute tiene que ser una imagen.",
	"in"               => "El campo :attribute seleccionado es invalido.",
	"integer"          => "El campo :attribute tiene que ser un numero entero.",
	"ip"               => "El campo :attribute tiene que ser una direccion IP valida.",
	"max"              => array(
		"numeric" => "El campo :attribute no puede ser mayor a :max.",
		"file"    => "El campo :attribute no puede ser mayor a :max kilobytes.",
		"string"  => "El campo :attribute no puede ser mayor a :max caracteres.",
		"array"   => "El campo :attribute no puede tener mas de :max elementos.",
	),
	"mimes"            => "El campo :attribute tiene que ser un archivo de tipo: :values.",
	"min"              => array(
		"numeric" => "El campo :attribute tiene que ser al menos :min",
		"file"    => "El campo :attribute tiene que tener al menos :min kilobytes.",
		"string"  => "El campo :attribute tiene que tener al menos :min caracteres.",
		"array"   => "El campo :attribute tiene que tener al menos :min elementos.",
	),
	"not_in"           => "El campo :attribute selecionado es invalido.",
	"numeric"          => "El campo :attribute tiene que ser un numero.",
	"regex"            => "El campo :attribute tiene un formato invalido.",
	"required"         => "El campo :attribute es requerido.",
	"required_if"      => "El campo :attribute es requerido cuando :other es :value.",
	"required_with"    => "El campo :attribute es requerido cuando :values esta presente.",
	"required_without" => "El campo :attribute es requerido cuando :values no esta presente.",
	"same"             => "Los campos :attribute y :other tienen que ser iguales.",
	"size"             => array(
		"numeric" => "El campo :attribute tiene que ser :size.",
		"file"    => "El campo :attribute tiene que ser de :size kilobytes.",
		"string"  => "El campo :attribute tiene que ser de :size caracteres.",
		"array"   => "El campo :attribute tiene que contener :size elementos.",
	),
	"unique"           => "El campo :attribute ya fue utilizado.",
	"url"              => "El campo :attribute tiene un formato invalido.",

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute.rule" to name the lines. This makes it quick to
	| specify a specific custom language line for a given attribute rule.
	|
	*/

	'custom' => array(),

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as E-Mail Address instead
	| of "email". This simply helps us make messages a little cleaner.
	|
	*/

	'attributes' => array(
		'first_name' => 'nombre',
		'last_name' => 'apellido',
		'email' => 'correo',
		'user_name' => 'nombre de usuario',
		'password' => 'contraseña',
		
		'course_name' => 'nombre del curso',
		'description' => 'descipcion',
		'created_at' => 'fecha de creacion',
		'started_at' => 'fecha de inicio',
		'closed_at' => 'fecha de cierre',

		'title' => 'titulo',	
		'type' => 'tipo',
		'updated_at' => 'fecha de actualizacion',

		'time' => 'tiempo',
		'start_date' => 'fecha de inicio',
		'end_date' => 'fecha de cierre',

		'url' => 'url',

		'question_text' => 'pregunta',
		'points' => 'puntos',
		'answer_text' => 'respuesta',
		'is_correct' => 'es correcta',
	),

);
