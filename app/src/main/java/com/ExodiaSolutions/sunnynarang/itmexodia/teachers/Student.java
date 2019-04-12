package com.ExodiaSolutions.sunnynarang.itmexodia.teachers;

import java.io.Serializable;

/**
 * Created by Sunny Narang on 05-08-2016.
 */

public class Student implements Serializable{

    String name;
    String roll;

    public String getImg() {
        return img;
    }

    public Student(String img, String roll, String name) {
        this.img = img;
        this.roll = roll;
        this.name = name;
    }

    String img;
   int status;


    public void setStatus(int status) {
        this.status = status;

    }

    public int getStatus() {

        return status;
    }


    Student(String name, String roll)
    {
        this.name = name;
        this.roll = roll;
        this.status = 1;
    }

    public String getName() {
        return name;
    }

    public String getRoll() {
        return roll;
    }
}
