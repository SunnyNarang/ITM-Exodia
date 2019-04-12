package com.ExodiaSolutions.sunnynarang.itmexodia.students;

/**
 * Created by Sunny Narang on 20-07-2016.
 */

public class files_class {

    String title,pdf,desc,teacher;

    public files_class(String tiile, String pdf, String desc, String teacher){
        this.title =tiile;
        this.pdf=pdf;
        this.desc=desc;
        this.teacher=teacher;

    }

    public String getTeacher() {
        return teacher;
    }

    public String getDesc() {
        return desc;
    }

    public String getPdf() {
        return pdf;
    }

    public String getTitle() {
        return title;
    }
}
