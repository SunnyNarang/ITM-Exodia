package com.ExodiaSolutions.sunnynarang.itmexodia;

/**
 * Created by Sunny Narang on 17-07-2016.
 */

public class person {
String name,image,roll;

    public person(String name, String image, String roll)
    {
        this.name=name;
       this.roll = roll;
        this.image=image;

    }

    public String getRoll() {
        return roll;
    }

    public String getImage() {
        return image;
    }

    public String getName() {
        return name;
    }
}
