






class View extends HTMLElement{
    constructor(){
        super();
    }
    connectedCallback() {
        let type = this.getAttribute("type");
        if(type == "left"){
            this.className = "view-left";            
        }else if(type == "right"){
            this.className = "view-right";
        }
    }
}

customElements.define("view-component", View);


class Slider extends HTMLElement{
    constructor(){
        super();
    }
    connectedCallback(){
        let images      = this.querySelectorAll("img");
        let div         = document.createElement("div");
        let leftButton  = document.createElement("div");
        let rightButton = document.createElement("div");
        let count       = images.length;
        let targetCount = 0;
        div.className   = "slider-images";
        leftButton.className = "slider-left-button";
        rightButton.className = "slider-right-button";
        leftButton.onclick = () => {
            targetCount--;
            if(targetCount < 0){
                targetCount = count;
            }
            div.style.right = 100 * targetCount + "%";
        };
        rightButton.onclick = () => {
            targetCount++;
            if(targetCount > count){
                targetCount = 0;
            }
            div.style.right = 100 * targetCount + "%";
        };
        leftButton.textContent = "<";
        rightButton.textContent = ">";
        this.append(div);
        this.append(leftButton);
        this.append(rightButton);
        images.forEach(el => {
            div.append(el);
        });
    }
}

customElements.define("slider-component", Slider);