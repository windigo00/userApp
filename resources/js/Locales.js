import $jquery from 'jquery';

/*
 * see locales.md for details
 */
const STORAGE_NONE    = 'none',
      STORAGE_LOCAL   = 'local',
      STORAGE_SESSION = 'session';

export class Locales {

    static get STORAGE_NONE() {
        return STORAGE_NONE;
    }

    static get STORAGE_LOCAL() {
        return STORAGE_LOCAL;
    }

    static get STORAGE_SESSION() {
        return STORAGE_SESSION;
    }

    constructor(config) {
        this.config = Object.assign({
            'storage' : false,   // if we should use web storage (local cache) [true|false|'session'|'local']. 'true' will use localStorage
            'route' : '',        // route to server where we get our data
            'module' : '',       // which modules we want to request from server
            'locale' : 'cz',     // what language we want to use
            'on' : {             // events
                beforeLoad : null,
                afterLoad  : null
            }
        }, config);

		this.__localeData = [];
        this.loaded = false;
        this.__moduleMatch = /^(.+)\.(.+)$/;
        this.__storageItemName = 'locales_cache';

        if (this.config.module && typeof this.config.module == 'string') {
            this.config.module = [ this.config.module ];
        }

        this.loadModuleLocales(function(){
            this.loaded = true;
        }.bind(this))
	}

    /**
     *
     *
     * @param array parameters First is the string, the other is object values for replacenemt
     * @returns sstring
     */
    translate() {
        var parameters = [""];

        //--- Prepare input ---
        if (arguments.length == 0) return "";
        //we have either string or object from filter call [string,{replacement:string}]
        if (arguments.length == 1) {
            if (arguments[0].length == 0) {
                console.log('no arguments for translation!');
                return '';
            }
            else if (typeof arguments[0] == 'object') {
                parameters = arguments[0];
            } else {
                parameters = [arguments[0]];
            }
        } else {//we take first two arguments. string and object
            parameters = [arguments[0]];
            if (arguments[1] && typeof arguments[1] == 'object') {
                parameters.push(arguments[1])
            }
        }
        //check for module part or prepare for lookup in "general" module
        var value = parameters[0];
        if (!(value = parameters[0].match(this.__moduleMatch))) {
            value = [parameters[0], "general", parameters[0]];
        }

        //data for replacement if any
        var replace = parameters[1] ? parameters[1] : null;

        if (this.__localeData) {
            var m = this.__localeData[value[1]];
            if (m) {
                var key = m.keys.indexOf(value[2]);
                if (key >= 0) {
                    value[2] = m.values[key]
                }
            }
        }
        return this.__replace((value[2] ? value[2] : value[0]), replace);
    }

    __replace(value, data) {
        if (data) {
            var tmpVal;
            for(var i in data) {
                value = typeof data[i] == 'function' ?
                    data[i](value) :
                    value.replace(':'+i, data[i])
            }
        }
        return value
    }

    changeLocale(newLocale) {
//        console.log('changing to '+newLocale);
        this.config.locale = newLocale;
        this.loaded = false;
        //#TODO figure out cashing.
        this.loadModuleLocales(function(){
            this.loaded = true;
        }.bind(this))
    }

    loadModuleLocales(callback) {
        if (this.config.storage) {
            if (this.__localeData = this.getStorage()) {
                if (callback) callback()
                return;
            }
        }
        if (this.config.route) {
            if (this.config.on.beforeLoad) {
                this.config.on.beforeLoad();
            }
            var data = {
                locale : this.config.locale,
                module : this.config.module
            };

            $jquery.get(this.config.route, data).then((response) => {
                if (response.error) {
                    console.log(response.error);
                } else {
                    this.__localeData = response;

                    if (this.config.storage)
                        this.setStorage(this.__localeData)

                    if (callback)
                        callback()
                }
                if (this.config.on.afterLoad) {
                    this.config.on.afterLoad();
                }
            });
        } else {
            console.log('Error! no route given for locales')
        }
    }

    setStorage(data) {
        if (this.config.storage == false || this.config.storage == Locales.STORAGE_NONE) {
            return;
        } else if (typeof(Storage) !== "undefined") {
            this.__getTypeStorage(this.config.storage)
                .setItem(this.config.locale+'_'+this.__storageItemName, JSON.stringify(data))
        } else {
            console.log('storage not accessible')
            return null;
        }
    }

    getStorage() {
        if (this.config.storage == false || this.config.storage == Locales.STORAGE_NONE) {
            return null;
        } else if (typeof(Storage) !== "undefined") {
            // Code for localStorage/sessionStorage.
            return JSON.parse(this.__getTypeStorage(this.config.storage)
                    .getItem(this.config.locale+'_'+this.__storageItemName))
        } else {
            console.log('storage not accessible')
            return null;
        }
    }

    __getTypeStorage(storage) {
        switch(storage) {
            case Locales.STORAGE_LOCAL :
                return window.localStorage;
            case Locales.STORAGE_SESSION :
                return window.sessionStorage;
            default :
                return window.localStorage;
        }
    }
}

