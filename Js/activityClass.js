export default class Activity {

    constructor(name, type, time, status, description, date, id=null) {
        this.id = id;
        this.name = name;
        this.type = type;
        this.time = time;
        this.status = status;
        this.description = description;
        this.date = date;
    }

}