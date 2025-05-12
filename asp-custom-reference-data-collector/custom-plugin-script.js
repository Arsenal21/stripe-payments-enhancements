var MyCustomPluginHandler = function (data) {
    // This callback triggers before the 'asp_pp_create_pi' ajax request executes.
    this.csBeforeRegenParams = function () {
        if (vars.data){
            const custom_plugin_input = document.getElementById('custom_plugin_input');//
            const custom_plugin_data = custom_plugin_input?.value;
            if (custom_plugin_data){
                vars.data.csRegenParams += '&custom_plugin_data=' + custom_plugin_data;
            }
        }
    }
}