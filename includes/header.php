<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($titulo_pagina) ? $titulo_pagina : "PetMatch"; ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body { 
            background: #0D0D0D !important; 
            color: white !important; 
            font-family: 'Segoe UI', Tahoma, sans-serif; 
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }
        /* Forçar fundo escuro no wrapper caso haja conflito */
        .main-container-wrapper {
            background: #0D0D0D;
            min-height: 100vh;
        }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #0D0D0D; }
        ::-webkit-scrollbar-thumb { background: #222; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #333; }


        
    </style>
</head>
<body>
<div class="main-container-wrapper">