user.service('userService', function(){

    // Asigna los valores originales a los input de editar los datos
    this.resetValues = function(originalData, editData) {
        editData.identity_card = originalData.identity_card;
        editData.name = originalData.name;
        editData.last_name = originalData.last_name;
        editData.school = originalData.school;
        editData.phone = originalData.phone;
    }
});