package com.ExodiaSolutions.sunnynarang.itmexodia.students;

/**
 * Created by Sunny Narang on 20-07-2016.
 */

class Sub_class1 {
    String id,name,code,type;

    public String getType() {
        return type;
    }

    Sub_class1(String id, String name, String code, String type){
        this.id = id;
        this.name= name;
        this.code= code;
        this.type = type;

    }

    public String getName() {
        return name;
    }

    public String getCode() {
        return code;
    }

    public String getId() {
        return id;
    }
}
