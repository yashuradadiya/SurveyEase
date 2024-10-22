function validateInput(input) {
    let value = input.value.trim();
    let type = input.getAttribute('type') || input.tagName.toLowerCase();
    
    switch (type) {
      case 'text':
      case 'textarea':
        if (value === "") {
          alert(input.name + " cannot be blank.");
          input.focus();
          return false;
        }
        break;
  
      case 'email':
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (value === "" || !emailPattern.test(value)) {
          alert(input.name + " is not a valid email.");
          input.focus();
          return false;
        }
        break;
  
      case 'number':
        if (value === "" || isNaN(value)) {
          alert(input.name + " must be a valid number.");
          input.focus();
          return false;
        }
        break;
  
      case 'tel':
        const phonePattern = /^[0-9]{10}$/;
        if (value === "" || !phonePattern.test(value)) {
          alert(input.name + " must be a valid 10-digit phone number.");
          input.focus();
          return false;
        }
        break;
  
      case 'select-one':
        if (input.selectedIndex === 0) {
          alert(input.name + " cannot be left unselected.");
          input.focus();
          return false;
        }
        break;
  
      default:
        if (value === "") {
          alert(input.name + " cannot be blank.");
          input.focus();
          return false;
        }
        break;
    }
  
    return true;
  }
  
  // Function to validate the entire form
  function validateForm(formId) {
    let form = document.getElementById(formId);
    let inputs = form.querySelectorAll("input[required], textarea[required], select[required]");
    
    // Iterate over all required fields
    for (let input of inputs) {
      if (!validateInput(input)) {
        return false; // Stop form submission if any field is blank or invalid
      }
    }
  
    return true; // All inputs are filled and valid
  }