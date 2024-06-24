class Liste {
    constructor(id) {
        this.parent = document.querySelector('#' + id + ' .table-wrapper');
        this.items = Array.from(document.querySelectorAll('#' + id + ' .table-wrapper table tbody tr'));
        this.observer = new IntersectionObserver(
            this.callback.bind(this), 
            {
                root: this.parent,
                rootMargin: '-60px 0px 0px 0px', 
                threshold: 1
            }
        );
        this.int();

        console.log(this.parent);
        console.log(this.items);
    }

    int() {
        this.items.forEach(item => {
            this.observer.observe(item);
        });
    }
    callback(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) 
                entry.target.classList.add('visible');
    
            else 
                entry.target.classList.remove('visible');
        });
    }
}