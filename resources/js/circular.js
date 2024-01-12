let circularProgress = document.querySelector(".circular-progress, .circular-progress-mahasiswaDosen"),
progressValue = document.querySelector(".progress-value");
let progressStartValue = 0,    
progressEndValue = 100,    
speed = 1;

let progress = setInterval(() => {
progressStartValue++;
progressValue.textContent = `${progressStartValue}%`
circularProgress.style.background = `conic-gradient(var(--color-primary) ${progressStartValue * 3.6}deg, #ededed 0deg)`
if(progressStartValue == progressEndValue){
    clearInterval(progress);
}    
}, speed);

console.log("herling ganteng")