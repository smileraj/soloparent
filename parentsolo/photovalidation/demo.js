/*
 * Testing
 */
//watermarks usadas
/* robocrop.watermarks = {
    main: {
        file: './img/watermark.png',
        opacity: 1,
        position: "bottom-right",
        margin_top: 0,
        margin_right: 5,
        margin_bottom: 5,
        margin_left: 0
    }
}; */

//before upload
/* robocrop.events.upload.before = function(picture){
    return [
        {name:'token' ,value:'xyz'},
        {name:'folder' ,value:'user'}
    ];
}; 

//upload terminado
robocrop.events.upload.end = function(response){
    console.log('upload complete');
    console.log(response);
};

//Upload de imagem em progresso
robocrop.events.upload.progress = function(picture,loaded,total){
    var value = Math.ceil(loaded/total) * 100;
    console.log('progress', value+'%');
};

//Edição foi concluída
robocrop.events.apply = function(picture){
    console.log('picture',picture);
};*/