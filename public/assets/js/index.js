  // Seleccionar todos los botones de tab
  var tabs = document.querySelectorAll('.tab');

  // Recorrer los botones y agregar el evento click a cada uno
  tabs.forEach(function(tab) {
    tab.addEventListener('click', function() {
      // Obtener el ID de la pestaña a mostrar
      var target = this.getAttribute('data-target');
      
      // Ocultar todas las pestañas
      document.querySelectorAll('.tab-pane').forEach(function(tabPane) {
        tabPane.classList.remove('active');
      });
      
      // Mostrar la pestaña correspondiente
      document.getElementById(target).classList.add('active');
      
      // Establecer la pestaña activa
      document.querySelectorAll('.tab').forEach(function(tab) {
        tab.classList.remove('active');
      });
      
      this.classList.add('active');
    });
  });