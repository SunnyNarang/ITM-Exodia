package com.ExodiaSolutions.sunnynarang.itmexodia.students;

import android.content.Context;
import android.os.Bundle;

import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.ListView;
import android.widget.TextView;

import com.ExodiaSolutions.sunnynarang.itmexodia.R;

import org.apache.commons.io.FileUtils;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.File;
import java.io.IOException;
import java.util.ArrayList;

/**
 * Created by shriram on 7/27/2016.
 */

public class PageFragment extends Fragment {
    public static final String ARG_PAGE = "ARG_PAGE";

    String day[] = new String[] {"", "Monday", "Tuesday", "Wednesday","Thursday", "Friday", "Saturday" };
    private int mPage;
    String timetable_json;

    public static PageFragment newInstance(int page) {
        Bundle args = new Bundle();
        args.putInt(ARG_PAGE, page);
        PageFragment fragment = new PageFragment();
        fragment.setArguments(args);
        return fragment;
    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        mPage = getArguments().getInt(ARG_PAGE);
    }

    @Override
    public Context getContext() {
        return super.getContext();
    }

    // Inflate the fragment layout we defined above for this fragment
    // Set the associated text for the title
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.activity_class_routine2, container, false);
        //TextView tvTitle = (TextView) view.findViewById(R.id.textView);
        // tvTitle.setText("Fragment #" + mPage);
        ArrayList<routine_class> arrayList = new ArrayList<>();
        ListView list = (ListView) view.findViewById(R.id.routine_list);
        //TextView tv = (TextView) view.findViewById(R.id.routine_head);
        //tv.setText(day[mPage] + "'s Routine");

        CustomAdapter adapter = new CustomAdapter(getContext(), arrayList);
        list.setAdapter(adapter);

        timetable_json = "";
        File filesDir = getContext().getFilesDir();
        File todoFile = new File(filesDir, Routine_Page.class_id+Routine_Page.batch+"class_routine.txt");
        try {
            timetable_json = new String(FileUtils.readFileToString(todoFile));
        } catch (IOException e) {
        }

        if (!timetable_json.equalsIgnoreCase("")) {
            try {

                JSONArray root = new JSONArray(timetable_json);

                for (int i = 0; i < root.length(); i++) {

                    JSONObject jsonObject = root.optJSONObject(i);
                    if(jsonObject.optString("day").equalsIgnoreCase(day[mPage])){

                    String start_time = jsonObject.optString("start_time");
                    String end_time = jsonObject.optString("end_time");
                    String name = jsonObject.optString("name");
                    String code = jsonObject.optString("code");
                     //   Toast.makeText(getContext(), ""+end_time, Toast.LENGTH_SHORT).show();
                    routine_class routine_class = new routine_class(start_time, end_time, code, name);
                    arrayList.add(routine_class);
                    }
                }
                adapter.notifyDataSetChanged();
            } catch (JSONException e) {
                e.printStackTrace();
            }}
            return view;

        }

        class CustomAdapter extends ArrayAdapter<routine_class> {
            Context c;

            public CustomAdapter(Context context, ArrayList<routine_class> arrayList) {
                super(context, R.layout.routine_class_element, arrayList);
                this.c = context;
            }


            @Override
            public View getView(int pos, View convertView, ViewGroup parent) {

                LayoutInflater li = (LayoutInflater) c.getSystemService(c.LAYOUT_INFLATER_SERVICE);
                convertView = li.inflate(R.layout.routine_class_element, parent, false);

                routine_class routine_class = getItem(pos);
                //Toast.makeText(c, ""+ routine_class.getEnd_time(), Toast.LENGTH_SHORT).show();
                TextView timev = (TextView) convertView.findViewById(R.id.time);
                TextView sub_namev = (TextView) convertView.findViewById(R.id.sub_name);
                TextView sub_codev = (TextView) convertView.findViewById(R.id.sub_code);
                String[] start = routine_class.getStart_time().split(":");
                String[] end = routine_class.getEnd_time().split(":");
                String ano_end="AM";
                String ano_start="AM";
                if (Integer.parseInt(start[0]) > 12)
                {start[0] = String.valueOf(Integer.parseInt(start[0]) % 12);

                    ano_start = "PM";
                }
                if (Integer.parseInt(end[0]) > 12){
                    end[0] = String.valueOf(Integer.parseInt(end[0]) % 12);

                    ano_end = "PM";
                }
                String time=start[0]+":"+start[1]+" "+ano_start+" - "+end[0]+":"+end[1]+" "+ano_end;

              //  Toast.makeText(c, ""+time, Toast.LENGTH_SHORT).show();
                timev.setText(time);
                sub_namev.setText(routine_class.getSub_name());
                sub_codev.setText(routine_class.getSub_code());

                return convertView;

            }
        }


    }
