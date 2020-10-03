/*
    NOME: PAULO VICTOR
    DATA: 03/10/2020
    HORA: 00:05
*/
$(document).ready(function(){
    
    var open = true;

    $('.btn-menu-left').on('click',function(){
        if(open){
            open = false;            
            $('.menu-left').css('width',0); 
            $('.menu-top').css('width','100%'); 
        }else{
            open = true;
            $('.menu-left').css('width','300px'); 
             
            $('.menu-top').css('width','calc(100% - 300px)'); 
        } 
    })
})