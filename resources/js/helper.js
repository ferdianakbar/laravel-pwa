
let saveToken = (vueObject, token, expire) => {
    vueObject.$cookies.set('token', token, expire)
}

let getToken =  (vueObject) => {
    return vueObject.$cookies.get('token');
}

let checkToken = function (vueObject) {
    let authToken = 'Bearer ' + getToken(vueObject)
    axios.get('check_auth', {
        headers: {
            'Authorization': authToken
        }
    }).then((res) => {
        if(res.status === 200) {
            vueObject.$root.loggedIn = true;
            vueObject.$axios.defaults.headers.common['Authorization']  = authToken
        }else {
            vueObject.$root.loggedIn = false;
        }
    }).catch((err) => {
        console.log(err)
        vueObject.$root.loggedIn = false;
    }).finally(function () {
        if (vueObject.$root.loggedIn && vueObject.$route.name === 'login') {
            vueObject.$router.replace({name: 'home'})
        }
    })
}

export {
    saveToken, getToken, checkToken
}
