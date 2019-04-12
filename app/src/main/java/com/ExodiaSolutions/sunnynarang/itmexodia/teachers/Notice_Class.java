package com.ExodiaSolutions.sunnynarang.itmexodia.teachers;

/**
 * Created by Sunny Narang on 19-07-2016.
 */

public class Notice_Class {

    String title,date,teacher,body;
    Notice_Class(String title, String date, String teacher, String body)
    {
        this.title=title;
        this.date=date;
        this.teacher=teacher;
        this.body=body;
    }

    public String getBody() {
        return body;
    }

    public String getDate() {
        return date;
    }

    public String getTeacher() {
        return teacher;
    }

    public String getTitle() {

        return title;
    }
}
