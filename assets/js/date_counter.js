export default class DateCounter {
    count() {
        let endTimeDiv = document.getElementById('start-date');
        let endTime = endTimeDiv.dataset.date;
        let countDownDate = new Date(endTime).getTime();

        let x = setInterval(function() {
            let now = new Date().getTime();
            let distance = countDownDate - now;

            let days = Math.floor(distance / (1000 * 60 * 60 * 24));
            let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            let seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById("event-one").innerHTML =
                `<span>${days} <br> <small>dni</small></span>  
                <span>${hours} <br> <small>g</small> </span> 
                <span>${minutes} <br> <small>min</small> </span> 
                <span>${seconds} <br> <small>sek</small></span> `;

            if (distance < 0) {
                clearInterval(x);
                document.getElementById("event-one").innerHTML = "Licznik poszedł odsapnąć ;)";
            }
        }, 1000);
    }
}
