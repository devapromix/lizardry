object FormInfo: TFormInfo
  Left = 0
  Top = 0
  BorderIcons = [biSystemMenu]
  BorderStyle = bsSingle
  Caption = 'Lizardry'
  ClientHeight = 458
  ClientWidth = 749
  Color = clBtnFace
  Font.Charset = DEFAULT_CHARSET
  Font.Color = clWindowText
  Font.Height = -11
  Font.Name = 'Tahoma'
  Font.Style = []
  OldCreateOrder = False
  PixelsPerInch = 96
  TextHeight = 13
  object PageControl1: TPageControl
    Left = 0
    Top = 0
    Width = 749
    Height = 458
    ActivePage = TabSheet5
    Align = alClient
    TabOrder = 0
    object TabSheet1: TTabSheet
      Caption = #1051#1086#1082#1072#1094#1080#1103
      object RichEdit1: TRichEdit
        Left = 0
        Top = 0
        Width = 741
        Height = 430
        Align = alClient
        Font.Charset = RUSSIAN_CHARSET
        Font.Color = clWindowText
        Font.Height = -11
        Font.Name = 'Tahoma'
        Font.Style = []
        ParentFont = False
        ScrollBars = ssVertical
        TabOrder = 0
        Zoom = 100
      end
    end
    object TabSheet2: TTabSheet
      Caption = #1055#1088#1077#1076#1084#1077#1090#1099
      ImageIndex = 1
      object RichEdit2: TRichEdit
        Left = 0
        Top = 0
        Width = 741
        Height = 430
        Align = alClient
        Font.Charset = RUSSIAN_CHARSET
        Font.Color = clWindowText
        Font.Height = -11
        Font.Name = 'Tahoma'
        Font.Style = []
        ParentFont = False
        ScrollBars = ssVertical
        TabOrder = 0
        Zoom = 100
      end
    end
    object TabSheet3: TTabSheet
      Caption = #1056#1077#1089#1091#1088#1089#1099
      ImageIndex = 2
      object MemoMobImages: TMemo
        Left = 0
        Top = 25
        Width = 741
        Height = 405
        Align = alClient
        ReadOnly = True
        TabOrder = 0
      end
      object MobImagesPath: TPanel
        Left = 0
        Top = 0
        Width = 741
        Height = 25
        Align = alTop
        Alignment = taLeftJustify
        BevelOuter = bvNone
        Caption = 'MobImagesPath'
        TabOrder = 1
      end
    end
    object TabSheet4: TTabSheet
      Caption = #1054#1096#1080#1073#1082#1080
      ImageIndex = 3
      object ErrorMemo: TMemo
        Left = 0
        Top = 0
        Width = 741
        Height = 430
        Align = alClient
        ReadOnly = True
        ScrollBars = ssBoth
        TabOrder = 0
      end
    end
    object TabSheet5: TTabSheet
      Caption = #1048#1085#1074#1077#1085#1090#1072#1088#1100
      ImageIndex = 4
      object InvMemo: TMemo
        Left = 0
        Top = 0
        Width = 741
        Height = 430
        Align = alClient
        TabOrder = 0
      end
    end
  end
end
