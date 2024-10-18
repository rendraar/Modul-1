let display = document.getElementById('display');

function appendValue(value) {
  display.value += value;
}

function clearDisplay() {
  display.value = '';
}

function calculate() {
  try {
    let lastChar = display.value[display.value.length - 1];
    if (['+', '-', '*', '/', '%', '**'].includes(lastChar)) {
      alert("Input terakhir harus angka");
    } else {
      display.value = eval(display.value);
    }
  } catch (error) {
    display.value = 'Error';
  }
}
