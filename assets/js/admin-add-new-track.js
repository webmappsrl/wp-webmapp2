
window.onbeforeunload = function(e){
    confirm = () => { return true; };
};

window.confirm = function(){ return true; };