let questionCount = document.querySelectorAll('.question-item').length;

function updateQuestionNumbers() {
    const questionItems = document.querySelectorAll('.question-item');
    questionItems.forEach((item, index) => {
        const questionNumber = index + 1;
        const label = item.querySelector('.form-label');
        label.innerText = `Question ${questionNumber}`;
        const input = item.querySelector('input[type="text"]');
        input.id = `question${questionNumber}`;
        input.setAttribute('placeholder', `Enter your question`);
        input.name = `question${questionNumber}`;

        const select = item.querySelector('.answer-type');
        select.name = `anstype${questionNumber}`;

        // Update options if they exist
        const optionItems = item.querySelectorAll('.option-item input');
        optionItems.forEach((option, optionIndex) => {
            option.name = `question${questionNumber}_option${optionIndex + 1}`;
            option.id = `question${questionNumber}_option${optionIndex + 1}`;
            option.setAttribute('placeholder', `Option ${optionIndex + 1}`);
        });
    });
}

function addQuestionAfter(questionWrapper) {
    questionCount++;
    const newQuestion = `
        <div class="question-wrapper">
            <div class="mb-3 question-item">
                <label for="question${questionCount}" class="form-label">Question ${questionCount}</label>
                <input type="text" class="form-control" id="question${questionCount}" placeholder="Enter your question" name="question${questionCount}">
                <label class="form-label mt-2">Answer Type</label>
                <select class="form-select answer-type" name="anstype${questionCount}">
                    <option value="text">Text</option>
                    <option value="textarea">Textarea</option>
                    <option value="email">Email</option>
                    <option value="tel">Telephone</option>
                    <option value="number">Number</option>
                    <option value="rating">Rating</option>
                    <option value="select">Select</option>
                    <option value="checkbox">Checkbox</option>
                    <option value="radio">Radio</option>
                </select>
                <div class="options-container mt-2"></div>
            </div>
            <button type="button" class="btn btn-secondary mt-2 add-between">Add Another Question</button>
            <button type="button" class="btn btn-danger mt-2 remove-question">Remove This Question</button>
        </div>`;
    
    $(newQuestion).insertAfter(questionWrapper); // Insert the new question right after the clicked one
    updateQuestionNumbers(); // Update question numbers after adding
}

// Show options for answer types like select, radio, or checkbox
function handleAnswerTypeChange(event) {
    const selectedType = $(event.target).val();
    const optionsContainer = $(event.target).closest('.question-item').find('.options-container');

    if (selectedType === 'select' || selectedType === 'radio' || selectedType === 'checkbox') {
        if (optionsContainer.children().length === 0) {
            addOptionFields(optionsContainer);
        }
    } else {
        optionsContainer.empty(); // Remove options if the type doesn't require them
    }
}

function addOptionFields(optionsContainer) {
    const questionWrapper = optionsContainer.closest('.question-item');
    const questionNumber = Array.from(document.querySelectorAll('.question-item')).indexOf(questionWrapper) + 1;

    const newOption = `
        <div class="option-item d-flex align-items-center mb-2">
            <input type="text" class="form-control" id="question${questionNumber}_option1" name="question${questionNumber}_option1" placeholder="Option 1">
            <button type="button" class="btn btn-success btn-sm ms-2 add-option">+</button>
            <button type="button" class="btn btn-danger btn-sm ms-2 remove-option">-</button>
        </div>`;
    optionsContainer.append(newOption); // Add the first option
}

function addOption(event) {
    const optionItem = $(event.target).closest('.option-item');
    const optionsContainer = optionItem.closest('.options-container');
    const optionCount = optionsContainer.children().length + 1; // Get the current count of options

    const questionWrapper = optionsContainer.closest('.question-item');
    const questionNumber = Array.from(document.querySelectorAll('.question-item')).indexOf(questionWrapper) + 1;

    const newOption = `
        <div class="option-item d-flex align-items-center mb-2">
            <input type="text" class="form-control" id="question${questionNumber}_option${optionCount}" name="question${questionNumber}_option${optionCount}" placeholder="Option ${optionCount}">
            <button type="button" class="btn btn-success btn-sm ms-2 add-option">+</button>
            <button type="button" class="btn btn-danger btn-sm ms-2 remove-option">-</button>
        </div>`;
    optionItem.after(newOption); // Adds the new option right after the current one
    updateOptionNumbers(optionsContainer); // Update option numbers after adding
}

function removeOption(event) {
    const optionItem = $(event.target).closest('.option-item');
    const optionsContainer = optionItem.closest('.options-container');
    optionItem.remove();
    updateOptionNumbers(optionsContainer); // Update option numbers after removal
}

function updateOptionNumbers(optionsContainer) {
    const optionItems = optionsContainer.children('.option-item');
    optionItems.each((index, item) => {
        const optionIndex = index + 1;
        const input = $(item).find('input[type="text"]');
        const questionWrapper = optionsContainer.closest('.question-item');
        const questionNumber = Array.from(document.querySelectorAll('.question-item')).indexOf(questionWrapper) + 1;
        
        input.attr('name', `question${questionNumber}_option${optionIndex}`);
        input.attr('id', `question${questionNumber}_option${optionIndex}`);
        input.attr('placeholder', `Option ${optionIndex}`);
    });
}

function removeQuestion(event) {
    $(event.target).closest('.question-wrapper').remove();
    updateQuestionNumbers();
}

// Event delegation for dynamically added elements
$(document).on('change', '.answer-type', handleAnswerTypeChange);
$(document).on('click', '.add-between', function() {
    const questionWrapper = $(this).closest('.question-wrapper'); // Find the closest question wrapper
    addQuestionAfter(questionWrapper); // Insert question at the correct position
});
$(document).on('click', '.remove-question', function(event) {
    removeQuestion(event); // Remove the selected question
});
$(document).on('click', '.add-option', addOption);
$(document).on('click', '.remove-option', removeOption);

// Initialize with first question if needed
$('#add-first-question').on('click', function() {
    if ($('#questions-container').children().length === 0) {
        addQuestionAfter(null); // Add the first question
    }
});
