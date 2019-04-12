package com.ExodiaSolutions.sunnynarang.itmexodia.teachers;

/**
 * Created by Sunny Narang on 08-07-2016.
 */

public class person {

    String name;
    String p,a,t;
    person(String name,String p,String a,String t){
        this.name=name;
        this.a=a;
        this.t=t;
        this.p=p;
    }

    public String getName() {
        return name;
    }
    public String getA()
    {
        return a;
    }
    public String getP()
    {
        return p;
    }
    public String getT()
    {
        return t;
    }



}
