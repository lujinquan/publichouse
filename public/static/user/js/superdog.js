function hasSuperDog(){
    res = true;
    if (window.ActiveXObject || "ActiveXObject" in window) {
        try {
            dogApplication = new ActiveXObject("SuperDog.DogApplicationEx");
        } catch (error) {
            return false;
        }
    } else {
        alert('请使用IE或使用手机登录');
        return false;
        // dogApplication = document.getElementById('dog_plugin');
    }

    try {
        res = LoginDefault();

    } catch (error) {
        console.log(error);
        return false;
    }
    return res;
}
function SessionInfoDemo(dog)
{
    if (window.ActiveXObject || "ActiveXObject" in window) {
        return SessionInfoDemo_IE(dog);
    } else {
        // alert('请使用IE');
        // SessionInfoDemo_NP(dog);
    }
}

function SessionInfoDemo_IE(dog)
{
    if (!dog)
        return;
    
    var info = dog.KeyInfo;
    var result = dog.GetSessionInfo(info);

    if (0 == result.Status)
    {
        var string = new String(result.String);
        string = string.replace(/\n/g, "\n   ");
    
        return $(string).find('dogid').text();
    }
    return false;

}

function LoginDemo(featureId)
{
    if (window.ActiveXObject || "ActiveXObject" in window)  //IE
    {
        return LoginDemo_IE(featureId);
    }
    else
    {
        alert('请使用IE');
        // return LoginDemo_NP(featureId);
    }
}
function LoginDemo_IE(featureId) {

    var feature = dogApplication.Feature(featureId);
    var dog = dogApplication.Dog(feature);
        
    var status = dog.Login();
    
    if (0 != status)
        dog = null;
    return dog;
}

function LoginDefault(){
    if (window.ActiveXObject || "ActiveXObject" in window) {
        return LoginDemoDefault_IE();
    } else {
        // alert('请使用IE');
        return false;
        // return LoginDemoDefault_NP();
    }
}

// function LoginDemoDefault_NP(){
//     var status = dogApplication.Login(0);
//     console.log(status);
//     if(status == 0){
//         return true;
//     } else {
//         return false;
//     }
// }

function LoginDemoDefault_IE(){
    var feature = dogApplication.DefaultFeature;
    var dog = dogApplication.Dog(feature);
    var status = dog.Login();
    if(status == 0){
        return true;
    } else {
        return false;
    }
}

